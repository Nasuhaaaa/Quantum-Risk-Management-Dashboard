@extends('layouts.app-layout')

@section('title', 'Daftar Pengguna Baru')

@section('content')

<div class="dashboard-header">
    <div>
        <h2>Tambah Pengguna</h2>
        <p>Pendaftaran Pengguna Sistem Baru</p>
    </div>
</div>

<a href="{{ route('admin.pengurusan_pengguna.index') }}" class="btn btn-sm btn-secondary mb-3">Kembali</a>

<div class="card-box">
    <h5>Borang Pendaftaran Pengguna</h5>

    <form method="POST" action="{{ route('admin.pengurusan_pengguna.store') }}">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">Nama Pengguna</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="jenis_pengguna_id" class="form-label">Jenis Pengguna</label>
            <select class="form-select @error('jenis_pengguna_id') is-invalid @enderror" id="jenis_pengguna_id" name="jenis_pengguna_id" required>
                <option value="">Pilih Jenis Pengguna</option>
                @foreach($jenisPenggunas as $jenisPengguna)
                    <option value="{{ $jenisPengguna->role_id }}" {{ old('jenis_pengguna_id') == $jenisPengguna->role_id ? 'selected' : '' }}>
                        {{ $jenisPengguna->jenis_pengguna }}
                    </option>
                @endforeach
            </select>
            @error('jenis_pengguna_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="agensi_id" class="form-label">Agensi (Untuk Entiti)</label>
            <select class="form-select @error('agensi_id') is-invalid @enderror" id="agensi_id" name="agensi_id">
                <option value="">Pilih Agensi</option>
                @foreach($agensis as $agensi)
                    <option value="{{ $agensi->id }}" {{ old('agensi_id') == $agensi->id ? 'selected' : '' }}>
                        {{ $agensi->nama_agensi }}
                    </option>
                @endforeach
            </select>
            @error('agensi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Laluan</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Sahkan Kata Laluan</label>
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Simpan</button>
            <a href="{{ route('admin.pengurusan_pengguna.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

<script>
    const roleSelect = document.getElementById('jenis_pengguna_id');
    const agensiSelect = document.getElementById('agensi_id');
    const entitiRoleId = @json($jenisPenggunas->firstWhere('jenis_pengguna', 'Entiti (Agensi)')?->role_id);

    function syncAgensiField() {
        const isEntiti = roleSelect.value !== '' && Number(roleSelect.value) === Number(entitiRoleId);
        agensiSelect.disabled = !isEntiti;

        if (!isEntiti) {
            agensiSelect.value = '';
        }
    }

    roleSelect.addEventListener('change', syncAgensiField);
    syncAgensiField();
</script>

@endsection
