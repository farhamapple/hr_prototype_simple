@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">DETAIL LAPORAN KARYAWAN PER DEPARTEMEN</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports-Karyawan</a></li>
                        <li class="breadcrumb-item active">Report-Karyawan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="container py-4">

                <!-- Button Kembali -->
                <div class="d-flex justify-content-between flex-row-reverse mb-4">
                    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary rounded-2 px-3 btn-sm">
                    Kembali
                    </a>
                </div>

                <!-- Card Info Departemen -->
                <div class="card border rounded-4 p-4 mb-4 shadow-sm">
                    <div class="row gy-3">
                    <div class="col-12">
                        <h2 class="fw-bold text-dark mb-0 mt-1">Departemen: {{ $report->department_name }}</h2>
                    </div>
                    <hr class="my-2 border-secondary-subtle">
                    <div class="col-12">
                        <span class="text-secondary fw-semibold small text-uppercase tracking-wider">MANAGER</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1">{{ $report->nama_manager ?? '-' }}</h5>
                    </div>
                    <hr class="my-2 border-secondary-subtle">
                    <div class="col-12">
                        <span class="text-secondary fw-semibold small text-uppercase tracking-wider">LOKASI</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1">{{ $report->street_address ?? '-' }}</h5>
                    </div>
                    </div>
                </div>

                <!-- Card Daftar Karyawan -->
                <div class="card border rounded-4 p-4 shadow-sm">

                    <!-- Table Header -->
                    <div class="row px-3 py-2 text-secondary fw-bold small text-uppercase border-bottom mb-3">
                        <div class="col-1">ID</div>
                        <div class="col-3">NAMA KARYAWAN</div>
                        <div class="col-2 text-center">JOB ID</div>
                        <div class="col-3">PEKERJAAN</div>
                        <div class="col-2 text-center">GAJI</div>
                        <div class="col-1 text-center">AKSI</div>
                    </div>

                    <!-- Rows Karyawan -->
                    <div class="d-flex flex-column gap-3">
                        @foreach($report->employees as $employee)
                            <div class="card border rounded-3 p-3 shadow-sm-hover">
                                <div class="row align-items-center">
                                    
                                    <!-- ID -->
                                    <div class="col-1 fw-secondary small">
                                        {{ $employee->employee_id }}
                                    </div>

                                    <!-- Nama Karyawan -->
                                    <div class="col-3 fw-bold text-dark">
                                        {{ $employee->employee_name }}
                                    </div>

                                    <!-- Job ID -->
                                    <div class="col-2 text-primary small text-center">
                                        {{ $employee->job_id }}
                                    </div>

                                    <!-- Pekerjaan -->
                                    <div class="col-3 text-dark small">
                                        {{ $employee->job_title }}
                                    </div>

                                    <!-- Gaji -->
                                    <div class="col-2 text-center text-dark fw-semibold small">
                                        {{ number_format($employee->salary) }}
                                    </div>

                                    <!-- Aksi -->
                                    <div class="col-1 text-center">
                                        <a class="fw-semibold link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('employees.show', $employee->employee_id) }}">Detail</a>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
