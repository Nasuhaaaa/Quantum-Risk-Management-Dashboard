<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="sidebar">
    <div class="sidebar-title">Papan Pemuka<br>Migrasi PQC</div>

    @auth
        <!-- Dashboard Link (All Roles) -->
        <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">Papan Pemuka</a>

        <!-- ENTITI MENU -->
        @if(auth()->user()->role_type === 'entiti')
            <div class="sidebar-section">Pengurusan Inventori</div>
            <a href="{{ route('entiti.pengurusan_inventori.create') }}" class="@if(request()->routeIs('entiti.pengurusan_inventori.create')) active @endif">Daftar Inventori</a>
            <a href="{{ route('entiti.pengurusan_inventori.index') }}" class="@if(request()->routeIs('entiti.pengurusan_inventori.index')) active @endif">Senarai Inventori</a>

            <div class="sidebar-section">Pengurusan Risiko</div>
            <a href="{{ route('entiti.pengurusan_inventori.index') }}" class="@if(request()->routeIs('entiti.pengurusan_inventori.show') || request()->routeIs('entiti.pengurusan_inventori.sbom.*') || request()->routeIs('entiti.pengurusan_inventori.cbom.*')) active @endif">Daftar Risiko</a>
            <a href="{{ route('entiti.pengurusan_risiko.risk_register.index') }}" class="@if(request()->routeIs('entiti.pengurusan_risiko.risk_register.*')) active @endif">Senarai Daftar Risiko</a>
            {{-- <a href="{{ route('entiti.pengurusan_risiko.risk_register.laporan_penilaian') }}">Laporan Penilaian Risiko</a> --}}

            <div class="sidebar-section">Lain-lain</div>
            {{-- <a href="{{ route('entiti.pengurusan_data.index') }}">Pengurusan Data</a> --}}
        @endif

        <!-- KETUA SEKTOR MENU -->
        @if(auth()->user()->role_type === 'ketua_sektor')
            <div class="sidebar-section">Pengurusan Risiko</div>
            <a href="{{ route('sektor.pengurusan_risiko.laporan_penilaian') }}" class="@if(request()->routeIs('sektor.pengurusan_risiko.*')) active @endif">Jana Laporan Penilaian Risiko</a>

            <div class="sidebar-section">Pengurusan Agensi</div>
            <a href="{{ route('sektor.pengurusan_agensi.create') }}" class="@if(request()->routeIs('sektor.pengurusan_agensi.create')) active @endif">Daftar Entiti</a>
            <a href="{{ route('sektor.pengurusan_agensi.index') }}" class="@if(request()->routeIs('sektor.pengurusan_agensi.index')) active @endif">Senarai Entiti</a>
        @endif

        <!-- PENGURUSAN MENU -->
        @if(auth()->user()->role_type === 'pengurusan')
            <div class="sidebar-section">Pengurusan Risiko</div>
            <a href="{{ route('pengurusan.pengurusan_risiko.index') }}" class="@if(request()->routeIs('pengurusan.pengurusan_risiko.index') || request()->routeIs('pengurusan.pengurusan_risiko.show')) active @endif">Senarai Daftar Risiko</a>
            <a href="{{ route('pengurusan.pengurusan_risiko.semak_sahkan') }}" class="@if(request()->routeIs('pengurusan.pengurusan_risiko.semak_sahkan') || request()->routeIs('pengurusan.pengurusan_risiko.approval*')) active @endif">Semak dan Sahkan Daftar Risiko</a>
            <a href="{{ route('pengurusan.pengurusan_risiko.laporan_penilaian') }}" class="@if(request()->routeIs('pengurusan.pengurusan_risiko.laporan_penilaian')) active @endif">Laporan Penilaian Risiko</a>
        @endif

        <!-- ADMIN MENU -->
        @if(auth()->user()->role_type === 'admin')
            <div class="sidebar-section">Pengurusan Pengguna</div>
            <a href="{{ route('admin.pengurusan_pengguna.create') }}" class="@if(request()->routeIs('admin.pengurusan_pengguna.create')) active @endif">Daftar Pengguna</a>
            <a href="{{ route('admin.pengurusan_pengguna.index') }}" class="@if(request()->routeIs('admin.pengurusan_pengguna.index')) active @endif">Senarai Pengguna</a>

            <div class="sidebar-section">Pengurusan Entiti</div>
            <a href="{{ route('admin.pengurusan_entiti.create') }}" class="@if(request()->routeIs('admin.pengurusan_entiti.create')) active @endif">Daftar Entiti</a>
            <a href="{{ route('admin.pengurusan_entiti.index') }}" class="@if(request()->routeIs('admin.pengurusan_entiti.index')) active @endif">Senarai Entiti</a>

            <div class="sidebar-section">Pengurusan Sektor</div>
            <a href="{{ route('admin.pengurusan_sektor.create') }}" class="@if(request()->routeIs('admin.pengurusan_sektor.create')) active @endif">Daftar Sektor</a>
            <a href="{{ route('admin.pengurusan_sektor.index') }}" class="@if(request()->routeIs('admin.pengurusan_sektor.index')) active @endif">Senarai Sektor</a>

            <div class="sidebar-section">Rujukan</div>
            <a href="{{ route('admin.rujukan.index') }}" class="@if(request()->routeIs('admin.rujukan.*')) active @endif">Pengurusan Rujukan dan Sumber Sokongan</a>
        @endif

        <div class="sidebar-section">Akaun</div>
        <a href="{{ route('logout.get') }}" class="btn btn-orange w-100" onclick="return confirm('Adakah anda pasti ingin keluar?')">Log Keluar</a>
    @endauth

    @guest
        <div class="sidebar-section">Akses</div>
        <a href="{{ route('login') }}" class="@if(request()->routeIs('login')) active @endif">Log Masuk</a>
    @endguest
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
