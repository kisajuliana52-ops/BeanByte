<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - System Error | BeanByte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#f8f6f2] flex items-center justify-center p-5">

    <div class="bg-white max-w-lg w-full rounded-3xl shadow-lg border border-gray-100 p-8 text-center">

        <div class="text-5xl mb-5">☕</div>

        <h2 class="text-2xl font-bold text-[#5b3825] mb-2">
            BeanByte
        </h2>

        <div class="w-20 h-20 mx-auto my-6 rounded-full bg-red-50 flex items-center justify-center">
            <span class="text-4xl">⚠️</span>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-3">
            Oops! Terjadi Kendala
        </h1>

        <p class="text-gray-500 text-sm leading-relaxed mb-6">
            Mohon maaf, sistem BeanByte sedang mengalami gangguan.
            Silakan coba kembali beberapa saat lagi.
        </p>

        <div class="bg-[#faf7f2] rounded-xl p-4 text-left text-sm mb-6">
            <p class="text-gray-700 font-semibold mb-2">
                Informasi Gangguan
            </p>
            <p class="text-gray-500">Kode Error: 500</p>
            <p class="text-gray-500">Status: Internal Server Error</p>
            <p class="text-gray-500">Sistem: BeanByte Coffee Shop</p>
        </div>

        <a href="{{ url('/') }}"
           class="block w-full bg-[#6f4932] hover:bg-[#543622] text-white font-semibold py-3 rounded-xl transition">
            Kembali ke Beranda
        </a>

        <p class="text-xs text-gray-400 mt-6">
            © {{ date('Y') }} BeanByte Coffee Shop
        </p>

    </div>

</body>
</html>
