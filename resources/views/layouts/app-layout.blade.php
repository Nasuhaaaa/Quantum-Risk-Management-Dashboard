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
    <div class="sidebar-title">PAPAN PEMUKA<br>MIGRASI PQC</div>

    @auth
        <!-- Dashboard Link (All Roles) -->
        <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">📊 Papan Pemuka</a>

        <!-- ENTITI MENU -->
        @if(auth()->user()->role_type === 'entiti')
            <div class="sidebar-section">Pengurusan Inventori</div>
            <a href="{{ route('entiti.pengurusan_inventori.create') }}">Daftar Inventori</a>
            <a href="{{ route('entiti.pengurusan_inventori.index') }}">Senarai Inventori</a>

            <div class="sidebar-section">Pengurusan Risiko</div>
            <a href="{{ route('entiti.pengurusan_inventori.index') }}">Daftar Risiko</a>
            <a href="{{ route('entiti.pengurusan_risiko.index') }}">Senarai Daftar Risiko</a>
            <a href="{{ route('entiti.pengurusan_risiko.laporan_penilaian') }}">Laporan Penilaian Risiko</a>

            <div class="sidebar-section">Lain-lain</div>
            <a href="{{ route('entiti.pengurusan_data.index') }}">Pengurusan Data</a>
        @endif

        <!-- KETUA SEKTOR MENU -->
        @if(auth()->user()->role_type === 'ketua_sektor')
            <div class="sidebar-section">Pengurusan Risiko</div>
            <a href="{{ route('sektor.pengurusan_risiko.laporan_penilaian') }}">Jana Laporan Penilaian Risiko</a>

            <div class="sidebar-section">Pengurusan Agensi</div>
            <a href="{{ route('sektor.pengurusan_agensi.create') }}">Daftar Entiti</a>
            <a href="{{ route('sektor.pengurusan_agensi.index') }}">Senarai Entiti</a>
        @endif

        <!-- PENGURUSAN MENU -->
        @if(auth()->user()->role_type === 'pengurusan')
            <div class="sidebar-section">Pengurusan Risiko</div>
            <a href="{{ route('pengurusan.pengurusan_risiko.index') }}">Senarai Daftar Risiko</a>
            <a href="{{ route('pengurusan.pengurusan_risiko.index') }}">Semak dan Sahkan Daftar Risiko</a>
            <a href="{{ route('pengurusan.pengurusan_risiko.laporan_penilaian') }}">Laporan Penilaian Risiko</a>
        @endif

        <!-- ADMIN MENU -->
        @if(auth()->user()->role_type === 'admin')
            <div class="sidebar-section">Pengurusan Pengguna</div>
            <a href="{{ route('admin.pengurusan_pengguna.create') }}">Daftar Pengguna</a>
            <a href="{{ route('admin.pengurusan_pengguna.index') }}">Senarai Pengguna</a>

            <div class="sidebar-section">Pengurusan Entiti</div>
            <a href="{{ route('admin.pengurusan_entiti.create') }}">Daftar Entiti</a>
            <a href="{{ route('admin.pengurusan_entiti.index') }}">Senarai Entiti</a>

            <div class="sidebar-section">Pengurusan Sektor</div>
            <a href="{{ route('admin.pengurusan_sektor.create') }}">Daftar Sektor</a>
            <a href="{{ route('admin.pengurusan_sektor.index') }}">Senarai Sektor</a>

            <div class="sidebar-section">Rujukan</div>
            <a href="{{ route('admin.rujukan.index') }}">Pengurusan Rujukan dan Sumber Sokongan</a>
        @endif

        <div class="sidebar-section">Akaun</div>
        <a href="{{ route('logout.get') }}" class="btn btn-orange w-100" onclick="return confirm('Adakah anda pasti ingin keluar?')">Log Keluar</a>
    @endauth

    @guest
        <div class="sidebar-section">Akses</div>
        <a href="{{ route('login') }}">Log Masuk</a>
    @endguest
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
