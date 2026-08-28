@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="callout callout-info">
                <h5>Selamat datang, {{ Auth::user()->name }}!</h5>
                <p>Anda telah berhasil masuk ke Sistem Manajemen HR.</p>
            </div>

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{ $totalEmployees }}</h3>
                            <p>Karyawan</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ $totalDepartments }}</h3>
                            <p>Departemen</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-building"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{ $totalLocations }}</h3>
                            <p>Lokasi</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>{{ $totalJobs }}</h3>
                            <p>Pekerjaan</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Distribusi Karyawan per Departemen</h3>
                        </div>
                        <div class="card-body">
                            @php $maxDept = $employeesPerDepartment->max('value') ?: 1; @endphp
                            @forelse ($employeesPerDepartment as $item)
                                <div class="d-flex justify-content-between mb-1">
                                    <span>{{ $item['label'] }}</span>
                                    <span class="text-muted">{{ $item['value'] }} karyawan</span>
                                </div>
                                <div class="progress mb-3" role="progressbar" aria-valuenow="{{ $item['value'] }}" aria-valuemin="0" aria-valuemax="{{ $maxDept }}">
                                    <div class="progress-bar" style="width: {{ $maxDept ? round(($item['value'] / $maxDept) * 100) : 0 }}%"></div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Belum ada data departemen.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Distribusi Karyawan per Wilayah</h3>
                        </div>
                        <div class="card-body">
                            @php $maxRegion = $employeesPerRegion->max('value') ?: 1; @endphp
                            @forelse ($employeesPerRegion as $item)
                                <div class="d-flex justify-content-between mb-1">
                                    <span>{{ $item->label }}</span>
                                    <span class="text-muted">{{ $item->value }} karyawan</span>
                                </div>
                                <div class="progress mb-3" role="progressbar" aria-valuenow="{{ $item->value }}" aria-valuemin="0" aria-valuemax="{{ $maxRegion }}">
                                    <div class="progress-bar bg-info" style="width: {{ $maxRegion ? round(($item->value / $maxRegion) * 100) : 0 }}%"></div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Belum ada data wilayah.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
