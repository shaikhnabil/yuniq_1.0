<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @stack('title') </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @yield('css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Macondo&display=swap" rel="stylesheet">

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
                <a href="/" class="d-flex align-items-start mb-2 mb-lg-0 text-light me-3 text-decoration-none">
                    <h3 class="text-warning macondo-regular">Yuniq</h3>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="/"
                                class="nav-link px-2 {{ request()->is('/') ? 'text-white' : 'text-secondary' }}">
                                <i class="bi bi-house"> Home</i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cart.index') }}"
                                class="nav-link px-2 {{ request()->routeIs('cart.index') ? 'text-white' : 'text-secondary' }}">
                                <i class="bi bi-cart4"> Cart</i>
                            </a>
                        </li>
                        @auth('admin')
                            <li class="nav-item">
                                <a href="/categories"
                                    class="nav-link px-2 {{ request()->is('categories') ? 'text-secondary' : 'text-white' }}">Categories</a>
                            </li>
                            <li class="nav-item">
                                <a href="/products"
                                    class="nav-link px-2 {{ request()->is('products') ? 'text-secondary' : 'text-white' }}">Products</a>
                            </li>
                        @endauth
                    </ul>

                    @guest
                        <div class="d-flex">
                            <a href="/login"
                                class="btn btn-outline-warning me-2 {{ request()->is('login') ? 'btn-warning' : '' }}">
                                <i class="bi bi-person-check"> Login</i>
                            </a>
                            <a href="/register"
                                class="btn btn-outline-warning {{ request()->is('register') ? 'btn-warning' : '' }}">
                                <i class="bi bi-people"> Sign-up</i>
                            </a>
                        </div>
                    @endguest
                    @auth
                        <div class="dropdown">
                            <button id="dropdownMenuButton" class="btn btn-outline-warning dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-circle btn btn-light"> Profile</i>
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <form action="{{ route('logout') }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-light">
                                            <i class="bi bi-box-arrow-right"> Logout</i>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </nav>
        </div>
    </header>
