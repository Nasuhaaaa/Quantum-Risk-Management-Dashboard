@extends('layouts.app-layout')

@section('title', 'Rujukan & Bantuan')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Rujukan & Bantuan</h2>
        <p>Panduan Penggunaan Sistem Risk Management</p>
    </div>
</div>

<!-- Navigation Tabs -->
<ul class="nav nav-tabs mb-4" id="helpTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ ($activeTab ?? 'bantuan') === 'bantuan' ? 'active' : '' }}" id="bantuan-tab" href="{{ route('admin.rujukan.bantuan') }}" role="tab" aria-controls="bantuan" aria-selected="{{ ($activeTab ?? 'bantuan') === 'bantuan' ? 'true' : 'false' }}">
            <i class="fas fa-book"></i> Bantuan
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ ($activeTab ?? 'bantuan') === 'pengaturan' ? 'active' : '' }}" id="pengaturan-tab" href="{{ route('admin.rujukan.pengaturan_sistem') }}" role="tab" aria-controls="pengaturan" aria-selected="{{ ($activeTab ?? 'bantuan') === 'pengaturan' ? 'true' : 'false' }}">
            <i class="fas fa-cog"></i> Pengaturan Sistem
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ ($activeTab ?? 'bantuan') === 'log' ? 'active' : '' }}" id="log-tab" href="{{ route('admin.rujukan.log') }}" role="tab" aria-controls="log" aria-selected="{{ ($activeTab ?? 'bantuan') === 'log' ? 'true' : 'false' }}">
            <i class="fas fa-history"></i> Log Sistem
        </a>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content" id="helpTabsContent">

    <!-- Bantuan Tab -->
    <div class="tab-pane fade {{ ($activeTab ?? 'bantuan') === 'bantuan' ? 'show active' : '' }}" id="bantuan" role="tabpanel" aria-labelledby="bantuan-tab">
        <div class="card-box mb-4">
            <h5>Panduan Pengguna Entiti</h5>
            <p>Sebagai pengguna Entiti, anda boleh:</p>
            <ul>
                <li>Mendaftar risiko baru dalam sistem</li>
                <li>Mengurusor risiko yang telah didaftar</li>
                <li>Melihat status persetujuan risiko dari pihak pengurusan</li>
                <li>Mengurusor inventori risiko</li>
                <li>Mengeluarkan laporan penilaian risiko</li>
            </ul>
        </div>

        <div class="card-box mb-4">
            <h5>Panduan Pengguna Ketua Sektor</h5>
            <p>Sebagai Ketua Sektor, anda boleh:</p>
            <ul>
                <li>Melihat semua risiko dalam sektor anda</li>
                <li>Mengurusor agensi dalam sektor anda</li>
                <li>Melihat laporan penilaian risiko sektor</li>
                <li>Memantau status persetujuan risiko dari pengurusan</li>
            </ul>
        </div>

        <div class="card-box mb-4">
            <h5>Panduan Pengguna Pengurusan</h5>
            <p>Sebagai pengguna Pengurusan, anda boleh:</p>
            <ul>
                <li>Menyemak risiko yang dihantar oleh entiti</li>
                <li>Menyetujui atau menolak risiko</li>
                <li>Memberikan ulasan kepada entiti</li>
                <li>Melihat laporan penilaian risiko</li>
            </ul>
        </div>

        <div class="card-box">
            <h5>Cara Mendaftar Risiko</h5>
            <ol>
                <li>Klik menu "Pengurusan Risiko" di sidebar</li>
                <li>Klik tombol "Tambah Risiko"</li>
                <li>Isi borang dengan maklumat risiko yang lengkap</li>
                <li>Pilih kategori dan sub-kategori risiko</li>
                <li>Tentukan tahap risiko berdasarkan kemungkinan dan kesan</li>
                <li>Klik "Simpan" untuk mendaftar risiko</li>
            </ol>
        </div>
    </div>

    <!-- Pengaturan Sistem Tab -->
    <div class="tab-pane fade {{ ($activeTab ?? 'bantuan') === 'pengaturan' ? 'show active' : '' }}" id="pengaturan" role="tabpanel" aria-labelledby="pengaturan-tab">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card-box h-100">
                    <h5>Maklumat Aplikasi</h5>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Nama Sistem</label>
                            <p class="mb-0">{{ $systemSettings['nama_sistem'] ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Versi Sistem</label>
                            <p class="mb-0">{{ $systemSettings['versi_sistem'] ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Persekitaran</label>
                            <p class="mb-0 text-capitalize">{{ $systemSettings['persekitaran'] ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Mod Debug</label>
                            <p class="mb-0">{{ $systemSettings['mod_debug'] ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Aplikasi</label>
                        <p class="mb-0">{{ $systemSettings['url_aplikasi'] ?? '-' }}</p>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label">Zon Masa</label>
                            <p class="mb-0">{{ $systemSettings['zon_masa'] ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Bahasa Sistem</label>
                            <p class="mb-0">{{ $systemSettings['bahasa'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-box h-100">
                    <h5>Status Infrastruktur</h5>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Pangkalan Data</label>
                            <p class="mb-0">
                                <span class="badge {{ $systemSettings['status_pangkalan_data_badge'] ?? 'bg-secondary' }}">
                                    {{ $systemSettings['status_pangkalan_data'] ?? '-' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Sambungan DB</label>
                            <p class="mb-0">{{ $systemSettings['sambungan_pangkalan_data'] ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Pemacu Sesi</label>
                            <p class="mb-0">{{ $systemSettings['pemacu_sesi'] ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Pemacu Cache</label>
                            <p class="mb-0">{{ $systemSettings['pemacu_cache'] ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Pemacu Queue</label>
                            <p class="mb-0">{{ $systemSettings['pemacu_queue'] ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Versi PHP</label>
                            <p class="mb-0">{{ $systemSettings['versi_php'] ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label">Jumlah Pengguna</label>
                            <p class="mb-0"><span class="badge bg-secondary">{{ $systemSettings['jumlah_pengguna'] ?? 0 }}</span></p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Jumlah Log Audit</label>
                            <p class="mb-0"><span class="badge bg-dark">{{ $systemSettings['jumlah_log_audit'] ?? 0 }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card-box">
                    <h5>Ringkasan Keselamatan</h5>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="small text-muted">Autentikasi</div>
                                <div class="fw-semibold">Log Masuk Aktif</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="small text-muted">Audit</div>
                                <div class="fw-semibold">Jejak Aktiviti Direkod</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="small text-muted">Sesi</div>
                                <div class="fw-semibold">Pemacu {{ $systemSettings['pemacu_sesi'] ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="small text-muted">Aplikasi</div>
                                <div class="fw-semibold">{{ $systemSettings['mod_debug'] ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Sistem Tab -->
    <div class="tab-pane fade {{ ($activeTab ?? 'bantuan') === 'log' ? 'show active' : '' }}" id="log" role="tabpanel" aria-labelledby="log-tab">
        <div class="card-box">
            <h5>Log Aktiviti Sistem</h5>

            @if($systemLogs && $systemLogs->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tarikh & Masa</th>
                            <th>Pengguna</th>
                            <th>Modul</th>
                            <th>Aktiviti</th>
                            <th>Butiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($systemLogs as $log)
                        <tr>
                            <td>{{ $log->created_at?->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $log->username ?? $log->user?->username ?? '-' }}</td>
                            <td>{{ $log->module ?? '-' }}</td>
                            <td>
                                @if($log->action === 'login')
                                    <span class="badge bg-success">Log Masuk</span>
                                @elseif($log->action === 'login_failed')
                                    <span class="badge bg-danger">Log Masuk Gagal</span>
                                @elseif($log->action === 'logout')
                                    <span class="badge bg-secondary">Log Keluar</span>
                                @elseif($log->action === 'create')
                                    <span class="badge bg-info">Buat</span>
                                @elseif($log->action === 'update')
                                    <span class="badge bg-warning">Kemas Kini</span>
                                @elseif($log->action === 'delete')
                                    <span class="badge bg-danger">Padam</span>
                                @elseif($log->action === 'error')
                                    <span class="badge bg-danger">Ralat</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($log->action) }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $log->description ?? '-' }}
                                @if(!empty($log->auditable_type) || !empty($log->auditable_id))
                                    <div class="small text-muted mt-1">
                                        Rekod: {{ $log->auditable_type ?? '-' }}@if($log->auditable_id) #{{ $log->auditable_id }} @endif
                                    </div>
                                @endif
                                @if(!empty($log->old_values))
                                    <div class="small text-muted mt-1">
                                        Sebelum: {{ json_encode($log->old_values, JSON_UNESCAPED_UNICODE) }}
                                    </div>
                                @endif
                                @if(!empty($log->new_values))
                                    <div class="small text-muted mt-1">
                                        Selepas: {{ json_encode($log->new_values, JSON_UNESCAPED_UNICODE) }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($systemLogs && $systemLogs instanceof \Illuminate\Pagination\LengthAwarePaginator && $systemLogs->hasPages())
            <div class="mt-3">
                {{ $systemLogs->links() }}
            </div>
            @endif
            @else
            <p class="text-muted text-center py-4">Tiada log aktiviti</p>
            @endif
        </div>
    </div>

</div>

@endsection
