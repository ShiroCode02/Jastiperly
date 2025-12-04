<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/feather-icons"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body { height: 100%; margin: 0; overflow: hidden; }
        .auth-wrapper { display: flex; height: 100vh; width: 100%; }

        .left-fixed {
            width: 50%; background: #344CB7; padding: 2.5rem; color: white;
            position: fixed; top: 0; left: 0; height: 100%; z-index: 10;
            display: flex; flex-direction: column;
        }
        .right-scrollable {
            width: 50%; margin-left: 50%; min-height: 100vh; background: #DBEDFF;
            overflow-y: auto; padding: 2rem 4rem;
        }
        /* Login = center, Register = mulai dari atas */
        .center-content { display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body class="font-sans antialiased h-full">

    <div class="auth-wrapper">
        <!-- LEFT FIXED -->
        <div class="left-fixed">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/login/logo.svg') }}" class="w-14 h-14">
                <div class="leading-tight">
                    <div class="text-[40px] font-bold">Selamat Datang</div>
                    <div class="text-[30px] font-semibold mt-1">Jastiperly</div>
                </div>
            </div>
            <div class="flex-1 flex items-center justify-center">
                <img src="{{ asset('images/login/testing.png') }}" class="w-[500px] h-[300px] object-contain">
            </div>
        </div>

        <!-- RIGHT — Otomatis center kalau halaman login, mulai atas kalau register -->
        <div class="right-scrollable {{ Request::is('login') || Request::is('forgot-password') ? 'center-content' : '' }}">
            <div class="w-full max-w-md {{ Request::is('login') || Request::is('forgot-password') ? '' : 'mx-auto' }}">
                {{ $slot }}
            </div>
        </div>
    </div>

</body>
</html>