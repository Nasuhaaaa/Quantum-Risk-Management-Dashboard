<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f3f4f6;
            font-size: 14px;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            padding: 20px;
        }

        .sidebar-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .sidebar-section {
            font-size: 12px;
            color: #6b7280;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .sidebar a {
            display: block;
            padding: 6px 0;
            text-decoration: none;
            color: #111827;
            font-size: 13px;
        }

        .content {
            margin-left: 260px;
            padding: 25px 40px;
        }

        .card-box {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
        }

        .section-title {
            font-weight: 600;
            color: #1f3c88;
            margin-top: 25px;
            margin-bottom: 15px;
        }

        .form-control, .form-select {
            height: 38px;
            border-radius: 6px;
            font-size: 13px;
        }

        textarea.form-control {
            height: auto;
        }

        .btn-orange {
            background-color: #f58220;
            color: white;
            border-radius: 6px;
            padding: 8px 20px;
        }

        .btn-grey {
            background-color: #d1d5db;
            border-radius: 6px;
            padding: 8px 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-title">PAPAN PEMUKA<br>MIGRASI PQC</div>

    <div class="sidebar-section">Pengurusan</div>
    <a href="#">Papan Pemuka</a>
    <a href="#">Senarai Risiko</a>

    <div class="sidebar-section">Daftar Risiko Kuantum</div>
    <a href="{{ route('risk_register.create') }}">Daftar Risiko</a>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
