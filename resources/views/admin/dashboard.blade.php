<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@stack('title')</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Include Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Macondo&display=swap" rel="stylesheet">

    @yield('css')
    <style>
        .macondo-regular {
            font-family: "Macondo";
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>

<body style="background-color: #FAF8F1">
    <!-- header -->
    <header class="p-2 text-bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a href="{{ route('admin.dashboard') }}"
                    class="d-flex align-items-start mb-2 mb-lg-0 text-light me-3 text-decoration-none">
                    <h3 class="mt-2 text-warning macondo-regular">Yuniq</h3>
                </a>
                <!-- Navbar Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Collapsible content -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @auth('admin')
                            <li class="nav-item">
                                <a href="/categories"
                                    class="nav-link px-2 {{ request()->is('categories') ? 'text-white' : 'text-secondary' }}">Categories</a>
                            </li>
                            <li class="nav-item">
                                <a href="/products"
                                    class="nav-link px-2 {{ request()->is('products') ? 'text-white' : 'text-secondary' }}">Products</a>
                            </li>
                        @endauth
                    </ul>

                    @guest('admin')
                        <div class="text-end">
                            <a href="{{ route('admin.login') }}" type="button"
                                class="me-2 {{ request()->is('admin.login') ? 'btn btn-warning' : 'btn btn-outline-warning' }}">Login</a>
                            <a href="{{ route('admin.register') }}" type="button"
                                class="{{ request()->is('admin.register') ? 'btn btn-warning' : 'btn btn-outline-warning' }}">Sign-up</a>
                        </div>
                    @else
                        <div class="text-end">
                            <form action="{{ route('admin.logout') }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit"
                                    class="me-2 {{ request()->is('admin.logout') ? 'btn btn-warning' : 'btn btn-outline-warning' }}">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>
            </nav>
        </div>
    </header>


    <main>
        @yield('main')
    </main>



    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Include Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
