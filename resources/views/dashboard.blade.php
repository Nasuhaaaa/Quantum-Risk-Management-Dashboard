@extends('layouts.app-layout')

@section('title', 'Papan Pemuka Risiko')

@section('content')
    @php
        // Determine the current user's role using the role_type accessor
        $currentRole = auth()->user()->role_type ?? 'entiti';
    @endphp

    {{-- Include the appropriate dashboard view based on user role --}}
    @switch($currentRole)
        @case('admin')
            @include('dashboard.admin')
            @break

        @case('ketua_sektor')
            @include('dashboard.ketua-sektor')
            @break

        @case('pengurusan')
            @include('dashboard.pengurusan')
            @break

        @default
            @include('dashboard.entiti')
    @endswitch
@endsection
