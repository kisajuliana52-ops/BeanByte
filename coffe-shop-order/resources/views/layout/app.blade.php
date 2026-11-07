<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        BeanByte - @yield('title', 'Pemesanan Kedai Kopi')
    </title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        /* =========================
           GLOBAL
        ========================= */

        body {
            background-color: #F8F5F1;
            color: #2E2118;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar-beanbyte {
            background-color: #4B2E20;
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: bold;
        }

        .brand-bean {
            color: #D6A56A;
        }

        .brand-byte {
            color: #FFFFFF;
        }

        .navbar-beanbyte .nav-link {
            color: #F5EDE6;
        }

        .navbar-beanbyte .nav-link:hover,
        .navbar-beanbyte .nav-link.active {
            color: #D6A56A;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn-beanbyte {
            background-color: #8B4A2F;
            color: #FFFFFF;
            border: none;
        }

        .btn-beanbyte:hover {
            background-color: #6F3925;
            color: #FFFFFF;
        }

        /* =========================
           MOBILE CARD
        ========================= */

        .menu-card {
            background-color: #FFFFFF;
            border-radius: 15px;
            border: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.06);
        }

        /* =========================
           FOOTER
        ========================= */

        .footer-beanbyte {
            background-color: #4B2E20;
            color: #D8C8BC;
        }

        /* =========================
           MOBILE BOTTOM NAVIGATION
        ========================= */

        .bottom-navigation {
            display: none;
        }

        @media (max-width: 767px) {

            body {
                padding-bottom: 70px;
            }

            .desktop-navigation {
                display: none;
            }

            .bottom-navigation {
                display: flex;

                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;

                height: 65px;

                background-color: #FFFFFF;

                border-top: 1px solid #E5DDD5;

                z-index: 1050;

                justify-content: space-around;
                align-items: center;

                box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
            }

            .bottom-navigation a {
                color: #81756D;

                text-decoration: none;

                font-size: 11px;

                text-align: center;
            }

            .bottom-navigation i {
                display: block;
                font-size: 21px;
                margin-bottom: 2px;
            }

            .bottom-navigation a.active {
                color: #8B4A2F;
                font-weight: bold;
            }
        }

    </style>

    @stack('styles')
</head>

<body>

    <!-- =================================
         NAVBAR UTAMA
    ================================== -->

    <nav class="navbar navbar-expand-lg navbar-dark navbar-beanbyte sticky-top shadow-sm">

        <div class="container">

            <!-- Logo -->

            <a class="navbar-brand" href="/">

                <span class="brand-bean">
                    Bean
                </span>

                <span class="brand-byte">
                    Byte
                </span>

            </a>


            <!-- Tombol Mobile -->

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarBeanByte"
                aria-controls="navbarBeanByte"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >

                <span class="navbar-toggler-icon"></span>

            </button>


            <!-- Menu -->

            <div
                class="collapse navbar-collapse desktop-navigation"
                id="navbarBeanByte"
            >

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">

                        <a
                            class="nav-link @yield('home_active')"
                            href="/"
                        >
                            <i class="bi bi-house"></i>
                            Beranda
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link @yield('menu_active')"
                            href="/menu"
                        >
                            <i class="bi bi-cup-hot"></i>
                            Menu
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link @yield('order_active')"
                            href="/orders"
                        >
                            <i class="bi bi-receipt"></i>
                            Pesanan
                        </a>

                    </li>

                </ul>


                <!-- Scan Barcode -->

                <div class="d-flex align-items-center">

                    <a
                        href="/scan-barcode"
                        class="btn btn-beanbyte btn-sm px-3 rounded-pill"
                    >

                        <i class="bi bi-qr-code-scan"></i>

                        Scan Barcode

                    </a>

                </div>

            </div>

        </div>

    </nav>


    <!-- =================================
         KONTEN DINAMIS
    ================================== -->

    <main class="container my-4">

        @yield('content')

    </main>


    <!-- =================================
         MOBILE BOTTOM NAVIGATION
    ================================== -->

    <nav class="bottom-navigation">

        <a
            href="/"
            class="@yield('home_active')"
        >

            <i class="bi bi-house"></i>

            Beranda

        </a>


        <a
            href="/menu"
            class="@yield('menu_active')"
        >

            <i class="bi bi-cup-hot"></i>

            Menu

        </a>


        <a
            href="/scan-barcode"
            class="@yield('scan_active')"
        >

            <i class="bi bi-qr-code-scan"></i>

            Scan

        </a>


        <a
            href="/cart"
            class="@yield('cart_active')"
        >

            <i class="bi bi-cart3"></i>

            Keranjang

        </a>


        <a
            href="/orders"
            class="@yield('order_active')"
        >

            <i class="bi bi-receipt"></i>

            Pesanan

        </a>

    </nav>


    <!-- =================================
         FOOTER
    ================================== -->

    <footer class="footer-beanbyte text-center py-3 mt-5 small">

        © 2026 BeanByte
        • Sistem Pemesanan Kedai Kopi
        • UKK RPL

    </footer>


    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

    @stack('scripts')

</body>
</html>