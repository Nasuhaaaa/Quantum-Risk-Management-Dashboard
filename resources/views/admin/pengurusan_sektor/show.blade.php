@extends('layouts.app-layout')

@section('title', 'Lihat Sektor')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Lihat Butiran Sektor</h2>
        <p>{{ $sector->nama_sektor }}</p>
    </div>
</div>

<a href="{{ route('admin.pengurusan_sektor.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Sector Details Card -->
<div class="card-box mb-4">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Sektor</label>
            <p class="mb-0">{{ $sector->nama_sektor }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Pengurus Sektor</label>
            <p class="mb-0">{{ $sector->pengurus_sektor ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Email Pengurus</label>
            <p class="mb-0">{{ $sector->email ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">No. Telefon</label>
            <p class="mb-0">{{ $sector->no_telefon ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Status</label>
            <p class="mb-0">
                @if($sector->status === 'aktif')
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Tidak Aktif</span>
                @endif
            </p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tarikh Daftar</label>
            <p class="mb-0">{{ $sector->created_at?->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    @if($sector->keterangan)
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label text-muted">Keterangan</label>
            <p class="mb-0">{{ $sector->keterangan }}</p>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.pengurusan_sektor.edit', $sector->id) }}" class="btn btn-warning">Ubah</a>
        <form method="POST" action="{{ route('admin.pengurusan_sektor.destroy', $sector->id) }}" style="display:inline;" onsubmit="return confirm('Adakah anda pasti?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Padam</button>
        </form>
        <a href="{{ route('admin.pengurusan_sektor.index') }}" class="btn btn-grey">Tutup</a>
    </div>
</div>

<!-- Entities in Sector -->
<div class="card-box">
    <h5>Agensi dalam Sektor Ini</h5>

    @if($sector->agensis && $sector->agensis->count() > 0)
    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead class="table-light">
                <tr>
                    <th>Nama Agensi</th>
                    <th>PIC</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sector->agensis as $agensi)
                <tr>
                    <td>{{ $agensi->nama_agensi }}</td>
                    <td>{{ $agensi->pic_nama ?? '-' }}</td>
                    <td>{{ $agensi->pic_email ?? '-' }}</td>
                    <td>
                        @if($agensi->status === 'aktif')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-muted text-center py-3">Tiada agensi dalam sektor ini</p>
    @endif
</div>

@endsection
