@extends('layouts.app-layout')

@section('title', 'Ubah Pengguna')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Ubah Pengguna</h2>
        <p>{{ $user->nama_lengkap }}</p>
    </div>
</div>

<a href="{{ route('admin.pengurusan_pengguna.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Form Card -->
<div class="card-box">
    <form method="POST" action="{{ route('admin.pengurusan_pengguna.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                       id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="no_telefon" class="form-label">No. Telefon</label>
                <input type="tel" class="form-control @error('no_telefon') is-invalid @enderror"
                       id="no_telefon" name="no_telefon" value="{{ old('no_telefon', $user->no_telefon) }}">
                @error('no_telefon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="jenis_pengguna" class="form-label">Jenis Pengguna</label>
                <select class="form-select @error('jenis_pengguna') is-invalid @enderror" id="jenis_pengguna" name="jenis_pengguna" required>
                    <option value="">Pilih Jenis</option>
                    <option value="entiti" {{ old('jenis_pengguna', $user->jenis_pengguna) == 'entiti' ? 'selected' : '' }}>Entiti</option>
                    <option value="ketua_sektor" {{ old('jenis_pengguna', $user->jenis_pengguna) == 'ketua_sektor' ? 'selected' : '' }}>Ketua Sektor</option>
                    <option value="pengurusan" {{ old('jenis_pengguna', $user->jenis_pengguna) == 'pengurusan' ? 'selected' : '' }}>Pengurusan</option>
                    <option value="admin" {{ old('jenis_pengguna', $user->jenis_pengguna) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('jenis_pengguna')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row" id="agensi_section" style="display:{{ old('jenis_pengguna', $user->jenis_pengguna) == 'entiti' ? 'block' : 'none' }}">
            <div class="col-md-6 mb-3">
                <label for="id_agensi" class="form-label">Agensi (Untuk Entiti)</label>
                <select class="form-select @error('id_agensi') is-invalid @enderror" id="id_agensi" name="id_agensi">
                    <option value="">Pilih Agensi</option>
                    @foreach($agensis as $agensi)
                    <option value="{{ $agensi->id }}" {{ old('id_agensi', $user->id_agensi) == $agensi->id ? 'selected' : '' }}>{{ $agensi->nama_agensi }}</option>
                    @endforeach
                </select>
                @error('id_agensi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Kata Laluan (Kosongkan jika tidak ingin ubah)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" placeholder="Kata laluan baru (opsional)">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label">Sahkan Kata Laluan</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="is_active" class="form-label">Status</label>
                <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                    <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Kemaskini</button>
            <a href="{{ route('admin.pengurusan_pengguna.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('jenis_pengguna').addEventListener('change', function() {
        const agensiSection = document.getElementById('agensi_section');
        if (this.value === 'entiti') {
            agensiSection.style.display = 'block';
        } else {
            agensiSection.style.display = 'none';
        }
    });
</script>

@endsection
