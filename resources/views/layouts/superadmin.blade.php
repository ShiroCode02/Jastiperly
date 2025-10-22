@extends('layouts.app') <!-- Asumsi ada layouts.app -->

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <!-- Sidebar menu (dari BRD: link ke fitur seperti Akses Penuh, Komisi, dll.) -->
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ route('superadmin.dashboard') }}">Overview</a></li>
                    <li class="list-group-item"><a href="/superadmin/dashboard/index2">Manage Admin/Finance</a></li>
                    <!-- Tambah link ke index3-10 -->
                </ul>
            </div>
            <div class="col-md-9">
                @yield('dashboard-content')
            </div>
        </div>
    </div>
@endsection

<style>
    /* Color Pallet dari PDF: Biru gradasi ke kuning/orange */
    body { background: linear-gradient(to bottom, #00BFFF, #FFD700); }
    .btn-masuk, .btn-simpan { background: #FF9500; color: white; } /* Orange */
    .btn-validasi, .btn-tolak { background: #FF0000; color: white; } /* Red */
    .btn-setujui, .btn-kirim { background: #00FF00; color: white; } /* Green */
    .btn-unduh { background: #FFFF00; color: black; } /* Yellow */
    .icon-edit { color: #FFD700; } /* Pensil yellow */
    .icon-view { color: #0000FF; } /* Mata blue */
    .icon-delete { color: #FF69B4; } /* Sampah pink */
</style>