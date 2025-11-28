<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            <!-- HEADER -->
            @include('_superadmin.settings.components.header')

            <!-- CARD CONTENT -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                @include('_superadmin.settings.components.card')
            </div>
        </div>
    </div>

    <script>
        document.getElementById('main-content').classList.remove('initial-hidden');
        const h = document.getElementById('navbar-header');
        if (h) h.classList.remove('initial-hidden');
    </script>
</x-app-layout>
