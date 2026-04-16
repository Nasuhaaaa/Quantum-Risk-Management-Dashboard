@extends('layouts.app-layout')

@section('title', 'Pengurusan Data Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Pengurusan Data Risiko</h2>
        <p>Import dan Export Data Risiko</p>
    </div>
    <div>
        <a href="{{ route('entiti.pengurusan_data.export_form') }}" class="btn btn-sm btn-secondary mr-2">
            <i class="fas fa-download"></i> Export
        </a>
        <a href="{{ route('entiti.pengurusan_data.import_form') }}" class="btn btn-sm btn-orange">
            <i class="fas fa-upload"></i> Import
        </a>
    </div>
</div>

<!-- Description Card -->
<div class="card-box mb-4">
    <h5>Panduan Pengurusan Data</h5>
    <p class="mb-2">Anda boleh menggunakan fungsi berikut untuk menguruskan data risiko:</p>
    <ul class="list-unstyled">
        <li><i class="fas fa-download text-orange"></i> <strong>Export:</strong> Muat turun data risiko dalam format Excel untuk penyimpanan atau analisis lanjut.</li>
        <li><i class="fas fa-upload text-orange"></i> <strong>Import:</strong> Muat naik data risiko daripada file Excel untuk daftar secara beramai-ramai.</li>
    </ul>
</div>

<!-- Statistics Card -->
<div class="card-box mb-4">
    <h5>Statistik Data</h5>
    <div class="row">
        <div class="col-md-4">
            <div class="text-center">
                <h3 class="text-orange">{{ $stats['total_risiko'] ?? 0 }}</h3>
                <p class="text-muted">Jumlah Risiko Terdaftar</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <h3 class="text-orange">{{ $stats['total_kategori'] ?? 0 }}</h3>
                <p class="text-muted">Kategori Risiko</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <h3 class="text-orange">{{ $stats['total_punca'] ?? 0 }}</h3>
                <p class="text-muted">Punca Risiko</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities Card -->
<div class="card-box">
    <h5>Aktiviti Terkini</h5>

    @if($recentActivities && $recentActivities->count() > 0)
    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead class="table-light">
                <tr>
                    <th>Tarikh</th>
                    <th>Jenis Aktiviti</th>
                    <th>Butiran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentActivities as $activity)
                <tr>
                    <td>{{ $activity->created_at?->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($activity->type === 'import')
                            <span class="badge bg-success">Import</span>
                        @elseif($activity->type === 'export')
                            <span class="badge bg-info">Export</span>
                        @else
                            <span class="badge bg-secondary">Lain-lain</span>
                        @endif
                    </td>
                    <td>{{ $activity->description ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-muted text-center py-3">Tiada aktiviti terkini</p>
    @endif
</div>

@endsection
