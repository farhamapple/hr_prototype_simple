@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">LAPORAN KARYAWAN PER DEPARTEMEN</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Reports-Karyawan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show p-3 mb-1" role="alert">
                    <p class="fw-bold">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show p-3 mb-1" role="alert">
                    <p class="fw-bold">{{ session('warning') }}</p>
                </div>
            @endif

            <div class="card p-2 shadow-sm">
                <div class="card-body p-4">
                    <!-- Table Header -->
                    <div class="row px-3 py-2 text-secondary fw-semibold small border-bottom mb-3">
                        <div class="col-1 text-center">No.</div>
                        <div class="col-3">Nama Departemen</div>
                        <div class="col-3 text-center">Karyawan</div>
                        <div class="col-3">Rata-rata Gaji</div>
                        <div class="col-2 text-end">Aksi</div>
                    </div>

                    <!-- Data Container (Card Rows) -->
                    <div class="d-flex flex-column gap-3">
                        @foreach($reports as $report)
                            <div class="card border rounded-3 p-3 shadow-sm-hover">
                                <div class="row align-items-center">
                                
                                    <!-- Nomor Urut -->
                                    <div class="col-1 text-center fw-semibold text-secondary small">
                                        {{ $loop->iteration }}.
                                    </div>

                                    <!-- Nama Departemen -->
                                    <div class="col-3">
                                        <h6 class="fw-bold text-dark">{{ $report->department_name }}</h6>
                                    </div>
                                    
                                    <!-- Karyawan -->
                                    <div class="col-3 text-center fw-bold text-dark">
                                        {{ $report->jml_karyawan }}
                                    </div>

                                    <!-- Rata-rata Gaji -->
                                    <div class="col-3 text-secondary">
                                        $ {{ number_format($report->rata_rata_gaji, 0, ',', '.') }}
                                    </div>
                                    
                                    <!-- Aksi -->
                                    <div class="col-2 text-end">
                                        <a href="{{ route('reports.show', $report->department_id) }}" class="fw-semibold link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                        Detail
                                        </a>
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
