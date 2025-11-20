<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            <!-- HEADER -->
            @include('_superadmin.users.components.header')

            <!-- TABEL -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                @include('_superadmin.users.components.table')
            </div>
        </div>
    </div>

    <!-- Delete -->
    @include('_superadmin.users.components.delete-modal')
    <script>
        document.getElementById('main-content').classList.remove('initial-hidden');
        document.getElementById('navbar-header').classList.remove('initial-hidden');
    </script>
</x-app-layout>