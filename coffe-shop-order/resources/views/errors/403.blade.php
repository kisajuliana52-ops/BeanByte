<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | BeanByte</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#f8f6f2] flex items-center justify-center p-5">

    <div class="bg-white max-w-lg w-full rounded-3xl shadow-lg border border-gray-100 p-8 text-center">

        <div class="text-5xl mb-4">☕</div>

        <h2 class="text-2xl font-bold text-[#5b3825]">BeanByte</h2>

        <div class="w-20 h-20 mx-auto my-6 rounded-full bg-red-50 flex items-center justify-center">
            <span class="text-4xl">🔒</span>
        </div>

        <h1 class="text-5xl font-black text-red-600 mb-2">403</h1>

        <h2 class="text-xl font-bold text-gray-800 mb-3">
            Akses Ditolak
        </h2>

        <p class="text-gray-500 text-sm leading-relaxed mb-6">
            Maaf, kamu tidak memiliki izin untuk membuka halaman ini.
            Silakan login menggunakan akun dengan hak akses yang sesuai.
        </p>

        <div class="bg-[#faf7f2] rounded-xl p-4 text-left text-sm mb-6">
            <p class="font-semibold text-gray-700 mb-2">Informasi Error</p>
            <p class="text-gray-500">Kode: 403 Forbidden</p>
            <p class="text-gray-500">Sistem: BeanByte Coffee Shop</p>
            <p class="text-gray-500">Status: Akses Ditolak</p>
        </div>

        <a href="{{ url('/login') }}"
           class="block w-full bg-[#6f4932] hover:bg-[#543622] text-white font-semibold py-3 rounded-xl transition">
            Kembali ke Login
        </a>

        <p class="text-xs text-gray-400 mt-6">
            © {{ date('Y') }} BeanByte Coffee Shop
        </p>

    </div>

</body>
</html>
