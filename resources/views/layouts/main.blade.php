<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.5.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="icon" type="image/x-icon" href={{ asset('favicon-rsi.png') }}>


    <link rel="stylesheet" type="text/css" href="/css/trix.css">
    <script type="text/javascript" src="/js/trix.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <style>
        .scroll-on-large {
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            .scroll-on-large {
                overflow-x: unset;
            }

            .responsive-table thead,
            .responsive-table td.hide-mobile,
            .responsive-table th.hide-mobile {
                display: none;
                /* Sembunyikan header */
            }

            .responsive-table,
            .responsive-table tbody,
            .responsive-table tr,
            .responsive-table td {
                display: block;
                width: 100%;
            }

            .responsive-table tr {
                margin-bottom: 1rem;
                border: 1px solid #dee2e6;
                border-radius: 0.5rem;
                background-color: #f8f9fa;
                padding: 0.5rem;
            }

            .responsive-table td {
                text-align: center;
                padding: 0.5rem;
                position: relative;
            }

            .responsive-table td::before {
                content: attr(data-label) ": ";
                color: #6c757d;
                /* font-weight: bold; */
                display: inline-block;
                margin-right: 0.25rem;
            }
        }

        .sticky-header {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 1;
        }
    </style>



    {{-- <link rel="icon" type="image/ico" sizes="32x32" href="/favicon.ico"> --}}
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png"> --}}

</head>

<body class="d-flex flex-column min-vh-100">

    <div class="wrapper">
        @can('dashboard-sekre')
            <aside id="sidebar" class="d-none d-md-block d-lg-block d-xl-block d-xxl-block expand">
                <div class="d-flex">
                    <button class="toggle-btn" type="button" id="toggle-btnnn">
                        <i class="fa-solid fa-hospital" style="color: #ffffff;"></i>
                    </button>
                    <div class="sidebar-logo">
                        <a href="/" style="text-decoration: none;">E-Sekretariat</a>
                    </div>
                </div>
                <ul class="sidebar-nav">

                    <li class="sidebar-item
          @if ($active == 'dashboard') active-tab @endif
           ">
                        <a href="/" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-house" style="color: #ffffff;"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    {{-- NAVBAR ADMIN --}}

                    <li class="sidebar-item
          @if ($active == 'surat masuk') active-tab @endif
           ">
                        <a href="/surat-masuk/index?tahun={{ config('app.tahun') }}" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-folder-closed" style="color: #ffffff;"></i>
                            <span>Surat Masuk</span>
                        </a>
                    </li>
                    <li class="sidebar-item
          @if ($active == 'surat keluar') active-tab @endif
           ">
                        <a href="/surat-keluar/index?tahun={{ config('app.tahun') }}" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-paper-plane" style="color: #ffffff;"></i>
                            <span>Surat Keluar</span>
                        </a>
                    </li>
                    <li class="sidebar-item
          @if ($active == 'spo') active-tab @endif
           ">
                        <a href="/spo/index?tahun={{ config('app.tahun') }}" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
                            <span>SPO</span>
                        </a>
                    </li>
                    <li class="sidebar-item
          @if ($active == 'regulasi') active-tab @endif
           ">
                        <a href="/regulasi/index?tahun={{ config('app.tahun') }}" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-gavel" style="color: #ffffff;"></i>
                            <span>Regulasi</span>
                        </a>
                    </li>
                    <li class="sidebar-item
          @if ($active == 'pks') active-tab @endif
           ">
                        <a href="/pks/index?tahun={{ config('app.tahun') }}" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-handshake-simple" style="color: #ffffff;"></i>
                            <span>PKS</span>
                        </a>
                    </li>
                    <li class="sidebar-item
          @if ($active == 'informasi') active-tab @endif
           ">
                        <a href="/informasi/index?tahun={{ config('app.tahun') }}" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-scroll" style="color: #ffffff;"></i>
                            <span>Informasi</span>
                        </a>
                    </li>
                    <li class="sidebar-item
          @if ($active == 'undangan') active-tab @endif
           ">
                        <a href="/undangan/index" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-envelope" style="color: #ffffff;"></i>
                            <span>Undangan</span>
                        </a>
                    </li>
                    <li class="sidebar-item
          @if ($active == 'laporan') active-tab @endif">
                        <a href="#" class="sidebar-link text-wrap collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                            <i class="fa-solid fa-file-lines" style="color: #ffffff;"></i>
                            <span>Laporan</span>
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" id="toggle-btnnn" class="sidebar-link text-wrap collapsed"
                                    data-bs-toggle="collapse" data-bs-target="#suratmasuk" aria-expanded="false"
                                    aria-controls="suratmasuk">
                                    Laporan Surat Masuk
                                </a>
                                <ul id="suratmasuk" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#multi">
                                    <li class="sidebar-item">
                                        <a href="/laporan/surat-masuk/per-direksi" class="sidebar-link text-wrap">Per
                                            Direksi</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link text-wrap collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#suratkeluar" aria-expanded="false" aria-controls="suratkeluar">
                                    Laporan Surat Keluar
                                </a>
                                <ul id="suratkeluar" class="sidebar-dropdown list-unstyled collapse"
                                    data-bs-parent="#multi">
                                    <li class="sidebar-item">
                                        <a href="/laporan/surat-keluar/per-jenis-surat" class="sidebar-link text-wrap">Per
                                            Jenis
                                            Surat</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="/laporan/surat-keluar/per-direksi" class="sidebar-link text-wrap">Per
                                            Direktorat</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link text-wrap collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#distribusisurat" aria-expanded="false"
                                    aria-controls="distribusisurat">
                                    Laporan Distribusi Surat
                                </a>
                                <ul id="distribusisurat" class="sidebar-dropdown list-unstyled collapse"
                                    data-bs-parent="#multi">
                                    <li class="sidebar-item">
                                        <a href="/laporan/distribusi-surat/posisi-terakhir"
                                            class="sidebar-link text-wrap">Posisi
                                            Distribusi Terakhir</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="/laporan/distribusi-surat/rekap/per-tujuan"
                                            class="sidebar-link text-wrap">Rekap
                                            Posisi Distribusi Terakhir</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="/laporan/distribusi-surat/sudah-selesai"
                                            class="sidebar-link text-wrap">Distribusi
                                            Surat Sudah Selesai</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="/laporan/distribusi-surat/pernah-distribusi"
                                            class="sidebar-link text-wrap">Yang
                                            Pernah Didistribusikan</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item @if ($active == 'data master') active-tab @endif
          ">
                        <a href="#" class="sidebar-link text-wrap collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                            <i class="fa-solid fa-database" style="color: #ffffff;"></i>
                            <span>Data Master</span>
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="/direksi/index" class="sidebar-link text-wrap">Direksi</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="/jenis-surat/index" class="sidebar-link text-wrap">Jenis Surat</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="/jenis-regulasi/index" class="sidebar-link text-wrap">Jenis Regulasi</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="/jenis-informasi/index" class="sidebar-link text-wrap">Jenis Informasi</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="/user/index" class="sidebar-link text-wrap">Tujuan Disposisi</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="/unit/index" class="sidebar-link text-wrap">Unit</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
        @endcan

        @can('dashboard-not-sekre')
            <aside id="sidebar" class="d-none d-md-block d-lg-block d-xl-block d-xxl-block expand">
                <div class="d-flex">
                    <button class="toggle-btn" type="button" id="toggle-btnnn">
                        <i class="fa-solid fa-hospital" style="color: #ffffff;"></i>
                    </button>
                    <div class="sidebar-logo">
                        <a href="/" style="text-decoration: none;">E-Sekretariat</a>
                    </div>
                </div>
                <ul class="sidebar-nav">

                    <li class="sidebar-item
          @if ($active == 'dashboard') active-tab @endif
           ">
                        <a href="/" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-house" style="color: #ffffff;"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item @if ($active == 'surat masuk') active-tab @endif
          ">
                        <a href="#" class="sidebar-link text-wrap collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                            <i class="fa-solid fa-folder-closed" style="color: #ffffff;"></i>
                            <span>Surat Masuk</span>
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="/surat-masuk/ns/belum-diteruskan" class="sidebar-link text-wrap">Belum
                                    Diteruskan</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="/surat-masuk/ns/sudah-diteruskan" class="sidebar-link text-wrap">Sudah
                                    Diteruskan</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="/surat-masuk/ns/sudah-diarsipkan" class="sidebar-link text-wrap">Sudah
                                    Diarsipkan</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item
          @if ($active == 'surat keluar') active-tab @endif
           ">
                        <a href="/surat-masuk/ns/dikirim" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-paper-plane" style="color: #ffffff;"></i>
                            <span>Surat Keluar</span>
                        </a>
                    </li>

                    <li class="sidebar-item
          @if ($active == 'spo') active-tab @endif
           ">
                        <a href="/spo/index/ns/" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
                            <span>SPO</span>
                        </a>
                    </li>

                    <li class="sidebar-item
          @if ($active == 'regulasi') active-tab @endif
           ">
                        <a href="/regulasi/index/ns/" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-gavel" style="color: #ffffff;"></i>
                            <span>Regulasi</span>
                        </a>
                    </li>

                    <li class="sidebar-item
          @if ($active == 'pks') active-tab @endif
           ">
                        <a href="/pks/index/ns/" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-handshake-simple" style="color: #ffffff;"></i>
                            <span>PKS</span>
                        </a>
                    </li>

                    <li class="sidebar-item
          @if ($active == 'informasi') active-tab @endif
           ">
                        <a href="/informasi/index/ns/" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-scroll" style="color: #ffffff;"></i>
                            <span>Informasi</span>
                        </a>
                    </li>

                    <li class="sidebar-item
          @if ($active == 'undangan') active-tab @endif
           ">
                        <a href="/undangan/index/ns" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-envelope" style="color: #ffffff;"></i>
                            <span>Undangan</span>
                        </a>
                    </li>

                    <li class="sidebar-item
          @if ($active == 'akun') active-tab @endif
           ">
                        <a href="/user/akun-ns" class="sidebar-link text-wrap">
                            <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                            <span>Akun</span>
                        </a>
                    </li>
                </ul>
            </aside>
        @endcan

        <div class="main">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid mx-3">
                    <a class="navbar-brand" href="#"><img src="/img/logorsi.png" width="150"
                            alt="Logo RSI"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        @can('dashboard-sekre')
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-md-none d-lg-none d-xl-none d-xxl-none">
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'dashboard') fw-bold @endif
                   "
                                        href="/">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'surat masuk') fw-bold @endif
                   "
                                        href="/surat-masuk/index?tahun={{ config('app.tahun') }}">Surat Masuk</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'surat keluar') fw-bold @endif
                   "
                                        href="/surat-keluar/index?tahun={{ config('app.tahun') }}">Surat Keluar</a>
                                </li>
                            </ul>

                            <ul
                                class="navbar-nav me-auto mb-2 mb-lg-0 d-none d-md-block d-lg-block d-xl-block d-xxl-block">
                                <li class="nav-item">
                                </li>
                            </ul>
                        @endcan

                        @can('dashboard-not-sekre')
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-md-none d-lg-none d-xl-none d-xxl-none">
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'dashboard') fw-bold @endif
                   "
                                        href="/">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'surat keluar') fw-bold @endif
                   "
                                        href="/surat-masuk/ns/dikirim">Dikirim</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'belum diteruskan') fw-bold @endif
                   "
                                        href="/surat-masuk/ns/belum-diteruskan">Belum Diteruskan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'sudah diteruskan') fw-bold @endif
                   "
                                        href="/surat-masuk/ns/sudah-diteruskan">Sudah Diteruskan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'sudah diarsipkan') fw-bold @endif
                   "
                                        href="/surat-masuk/ns/sudah-diarsipkan">Sudah Diarsipkan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'spo') fw-bold @endif
                   "
                                        href="/spo/index/ns">SPO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'regulasi') fw-bold @endif
                   "
                                        href="/regulasi/index/ns">Regulasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'pks') fw-bold @endif
                   "
                                        href="/pks/index/ns">PKS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'informasi') fw-bold @endif
                   "
                                        href="/informasi/index/ns">Informasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center fs-6
                  @if ($active == 'akun') fw-bold @endif
                   "
                                        href="/user/akun-ns">Akun</a>
                                </li>
                            </ul>

                            <ul
                                class="navbar-nav me-auto mb-2 mb-lg-0 d-none d-md-block d-lg-block d-xl-block d-xxl-block">
                                <li class="nav-item">
                                </li>
                            </ul>
                        @endcan

                        <span class="me-5 d-none d-md-block">{{ auth()->user()->namaJabatan }}</span>

                        <form action="/logout" method="post">
                            @csrf
                            <button type="button" class="btn btn-danger container-fluid btn-sm"
                                data-bs-toggle="modal" data-bs-target="#modalLogout">Logout</button>

                            <!-- Modal Tombol Logout -->
                            <div class="modal fade" data-bs-backdrop="static" id="modalLogout" tabindex="-1"
                                aria-labelledby="modalLogoutLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modalLogoutLabel">Keluar dari aplikasi
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Anda yakin ingin keluar dari aplikasi?
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <button type="submit" class="btn btn-danger">Logout</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>

            <main class="content px-3 py-1">
                <div class="container-fluid">
                    @yield('container')

                </div>
            </main>

            <footer class="bg-body-tertiary text-center text-lg-start mt-auto">
                <!-- Copyright -->
                <div class="text-center p-1" style="background-color: rgba(0, 0, 0, 0.05);">
                    © 2024 Copyright: RSISA Banjarbaru
                </div>
                <!-- Copyright -->
            </footer>

        </div>
    </div>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/script.js"></script>
</body>

</html>
