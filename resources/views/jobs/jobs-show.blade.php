@extends('layouts.app')

@section('title', 'Jobs')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">DETAIL PEKERJAAN (JOBS)</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
                        <li class="breadcrumb-item active">Detail Job</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card p-4 shadow-sm">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="d-block text-muted small text-uppercase fw-bold mb-2">Job ID</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $job->job_id }}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="d-block text-muted small text-uppercase fw-bold mb-2">Job Title</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $job->job_title }}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="d-block text-muted small text-uppercase fw-bold mb-2">Min Salary</label>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 fs-6">
                                {{-- Rp {{ number_format($job->min_salary, 0, ',', '.') }} --}}
                                {{ $job->min_salary }}
                            </span>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="d-block text-muted small text-uppercase fw-bold mb-2">Max Salary</label>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2 fs-6">
                                {{-- Rp {{ number_format($job->max_salary, 0, ',', '.') }} --}}
                                {{ $job->max_salary }}
                            </span>
                        </div>
                        
                    </div>
                    
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('jobs.edit', $job->job_id) }}" class="btn btn-warning flex-fill text-white fw-semibold py-2">
                            Edit
                        </a>
                        <form action="{{ route('jobs.destroy', $job->job_id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Apakah Anda yakin ingin menghapus job ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 fw-semibold py-2">
                                Hapus
                            </button>
                        </form>
                        <a href="{{ route('jobs.index', $job->job_id) }}" class="btn btn-outline-secondary flex-fill fw-semibold py-2">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection
