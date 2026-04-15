@extends('layouts.app-layout')

@section('title', 'Papan Pemuka - Pengurusan')

@section('content')
    <div class="dashboard-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Papan Pemuka Pengurusan</h2>
            <p>Selamat datang, {{ auth()->user()->name }}. Semak tahap risiko merentas semua sektor.</p>
        </div>
        <div>
            <span class="badge dashboard-badge bg-warning">Pengurusan</span>
        </div>
    </div>

    <div class="card-box">
        <h5 class="mb-4">Senarai Tahap Risiko Setiap Sektor</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Sektor</th>
                        <th>Tahap Risiko</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sectors as $sector)
                        <tr>
                            <td>
                                <strong>{{ $sector }}</strong>
                            </td>
                            <td>
                                @php
                                    $riskLevel = $sectorRiskData[$sector] ?? 'Tiada Data';
                                @endphp
                                @if($riskLevel === 'Tiada Data')
                                    <span class="badge bg-secondary">Tiada Data</span>
                                @else
                                    <span class="badge bg-danger">{{ $riskLevel }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">Tiada sektor untuk dipaparkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
