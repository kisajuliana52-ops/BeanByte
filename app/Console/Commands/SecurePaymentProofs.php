<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SecurePaymentProofs extends Command
{
    protected $signature = 'beanbyte:secure-payment-proofs {--apply : Move existing proof files to private storage}';

    protected $description = 'Move existing payment proof files from public to private storage';

    public function handle(): int
    {
        $apply = (bool) $this->option('apply');
        $stats = [
            'checked' => 0,
            'migrated' => 0,
            'removed_public_copies' => 0,
            'orphaned_files' => 0,
            'missing' => 0,
            'invalid' => 0,
            'failed' => 0,
        ];

        DB::table('transaksis')
            ->select('id_transaksi', 'bukti_pembayaran')
            ->whereNotNull('bukti_pembayaran')
            ->orderBy('id_transaksi')
            ->chunkById(100, function ($rows) use (&$stats, $apply): void {
                foreach ($rows as $row) {
                    $this->processProof($row, $stats, $apply);
                }
            }, 'id_transaksi');

        $this->processUnreferencedPublicFiles($stats, $apply);

        $this->newLine();
        $this->info('Catatan bukti diperiksa: ' . $stats['checked']);
        $this->info(
            ($apply ? 'File dipindahkan/diamankan: ' : 'File yang siap diamankan: ') .
            $stats['migrated']
        );
        $this->info(
            ($apply ? 'Salinan publik dihapus: ' : 'Salinan publik untuk dihapus: ') .
            $stats['removed_public_copies']
        );
        $this->info(
            ($apply ? 'File yatim diamankan: ' : 'File yatim yang akan diamankan: ') .
            $stats['orphaned_files']
        );
        $this->warn('File tidak ditemukan: ' . $stats['missing']);
        $this->warn('Path tidak valid: ' . $stats['invalid']);
        $this->line('Gagal diproses: ' . $stats['failed']);

        if (!$apply) {
            $this->newLine();
            $this->comment('Dry run: tidak ada file atau data yang diubah.');
            $this->comment('Setelah backup, jalankan dengan --apply pada server yang memakai database production.');
        }

        return (
            $stats['failed'] > 0 ||
            $stats['missing'] > 0 ||
            $stats['invalid'] > 0
        ) ? self::FAILURE : self::SUCCESS;
    }

    private function processProof(object $row, array &$stats, bool $apply): void
    {
        $stats['checked']++;
        $storedPath = (string) $row->bukti_pembayaran;
        $alreadyPrivate = str_starts_with($storedPath, 'private/');
        $relativePath = $alreadyPrivate
            ? substr($storedPath, strlen('private/'))
            : $storedPath;

        if (
            !str_starts_with($relativePath, 'bukti-pembayaran/') ||
            str_contains($relativePath, '..') ||
            str_contains($relativePath, '\\')
        ) {
            $stats['invalid']++;
            $this->warn('Path dilewati untuk transaksi #' . $row->id_transaksi . '.');

            return;
        }

        $publicExists = Storage::disk('public')->exists($relativePath);
        $privateExists = Storage::disk('local')->exists($relativePath);

        if (!$apply) {
            if (!$publicExists && !$privateExists) {
                $stats['missing']++;
            } elseif ($publicExists) {
                $stats['migrated']++;
            } elseif ($privateExists) {
                $stats['migrated']++;
            }

            if ($publicExists) {
                $stats['removed_public_copies']++;
            }

            return;
        }

        if (!$privateExists) {
            if (!$publicExists || !$this->copyToPrivateDisk($relativePath)) {
                $stats[$publicExists ? 'failed' : 'missing']++;
                $this->warn('File transaksi #' . $row->id_transaksi . ' belum dipindahkan.');

                return;
            }

            $privateExists = true;
        }

        if (!$alreadyPrivate) {
            $privateDbPath = 'private/' . $relativePath;
            $updated = DB::table('transaksis')
                ->where('id_transaksi', $row->id_transaksi)
                ->where('bukti_pembayaran', $storedPath)
                ->update(['bukti_pembayaran' => $privateDbPath]);

            if (!$updated) {
                $currentPath = DB::table('transaksis')
                    ->where('id_transaksi', $row->id_transaksi)
                    ->value('bukti_pembayaran');

                if ($currentPath !== $privateDbPath) {
                    $stats['failed']++;
                    $this->warn('Path transaksi #' . $row->id_transaksi . ' berubah saat diproses.');

                    return;
                }
            }
        }

        if ($publicExists) {
            if (!Storage::disk('public')->delete($relativePath)) {
                $stats['failed']++;
                $this->warn('Salinan publik transaksi #' . $row->id_transaksi . ' belum terhapus.');

                return;
            }

            $stats['removed_public_copies']++;
        }

        $stats['migrated']++;
    }

    private function copyToPrivateDisk(string $relativePath): bool
    {
        $stream = Storage::disk('public')->readStream($relativePath);

        if (!is_resource($stream)) {
            return false;
        }

        try {
            return Storage::disk('local')->put($relativePath, $stream);
        } finally {
            fclose($stream);
        }
    }

    private function processUnreferencedPublicFiles(array &$stats, bool $apply): void
    {
        $publicFiles = Storage::disk('public')->allFiles('bukti-pembayaran');

        if (!$publicFiles) {
            return;
        }

        $pathsInDatabase = DB::table('transaksis')
            ->whereNotNull('bukti_pembayaran')
            ->pluck('bukti_pembayaran');
        $legacyPaths = [];
        $privatePaths = [];

        foreach ($pathsInDatabase as $storedPath) {
            if (str_starts_with($storedPath, 'private/')) {
                $privatePaths[substr($storedPath, strlen('private/'))] = true;
            } else {
                $legacyPaths[$storedPath] = true;
            }
        }

        foreach ($publicFiles as $path) {
            if (!str_starts_with($path, 'bukti-pembayaran/') || str_contains($path, '..')) {
                continue;
            }

            if (isset($legacyPaths[$path])) {
                continue;
            }

            if (!$apply) {
                $stats['orphaned_files']++;

                continue;
            }

            if (
                !Storage::disk('local')->exists($path) &&
                !$this->copyToPrivateDisk($path)
            ) {
                $stats['failed']++;
                $this->warn('File tanpa transaksi belum dapat diamankan.');

                continue;
            }

            if (!Storage::disk('public')->delete($path)) {
                $stats['failed']++;
                $this->warn('Salinan publik file tanpa transaksi belum terhapus.');

                continue;
            }

            if (isset($privatePaths[$path])) {
                $stats['removed_public_copies']++;
            } else {
                $stats['orphaned_files']++;
            }
        }
    }
}
