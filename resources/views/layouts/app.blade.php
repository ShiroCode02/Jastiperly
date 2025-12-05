<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/htmx.org@1.9.12"></script>
        <script>
        // Logout otomatis HANYA kalau user idle (tidak gerak) lebih dari 30 menit
        let idleTimer;

        function resetTimer() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(() => {
                // Hanya logout kalau benar-benar idle lama
                fetch('{{ route("logout") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({}),
                    keepalive: true
                });
            }, 30 * 60 * 1000); // 30 menit
        }

        // Reset timer saat user gerak/klik/tik keyboard
        window.addEventListener('mousemove', resetTimer);
        window.addEventListener('mousedown', resetTimer);
        window.addEventListener('keypress', resetTimer);
        window.addEventListener('scroll', resetTimer);
        window.addEventListener('touchstart', resetTimer);
        window.addEventListener('click', resetTimer);

        // Mulai timer saat halaman dibuka
        resetTimer();
        </script>
    </head>
    <body class="font-sans antialiased bg-[#DBEDFF] min-h-screen">
        
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </body>
</html>
