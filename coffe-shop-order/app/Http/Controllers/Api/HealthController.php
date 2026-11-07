<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;

class HealthController extends Controller
{
    /**
     * Mengecek kesiapan server API dan status konektivitas basis data MySQL
     * Output dirender dalam format JSON (REST API Standard)
     */
    public function check()
    {
        try {
            // Melakukan ping query sederhana ke MySQL
            DB::connection()->getPdo();
            $dbStatus = "CONNECTED";
            
            // Menghitung data awal uji coba (Seed Data) pada tabel rooms
            $roomCount = DB::table('rooms')->count();
        } catch (Exception $e) {
            $dbStatus = "DISCONNECTED: " . $e->getMessage();
            $roomCount = 0;
        }

        // Mengembalikan HTTP Status 200 dengan payload JSON
        return response()->json([
            'success' => true,
            'message' => 'API Connection Established',
            'data' => [
                'system_name' => 'CoffeShopOrder REST API',
                'sprint_stage' => 'Sprint 1 - API Foundation Ready',
                'database_status' => $dbStatus,
                'active_rooms_seeded' => $roomCount,
                'timestamp' => now()->toIso8601String()
            ]
        ], 200);
    }
}
