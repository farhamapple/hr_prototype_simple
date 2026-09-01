@extends('layouts.app')

@section('title', 'Jobs')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">TAMBAH PEKERJAAN (JOBS) BARU</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
                        <li class="breadcrumb-item active">Tambah Job</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            
            <div class="card p-4 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('jobs.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="job_id" class="form-label fw-semibold">
                                Job ID <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                name="job_id"
                                id="job_id"
                                value="{{ old('job_id') }}"
                                class="form-control @error('job_id') is-invalid @enderror"
                                placeholder="Contoh: AD_PRES"
                                required>
                            @error('job_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="job_title" class="form-label fw-semibold">
                                Job Title <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                name="job_title"
                                id="job_title"
                                value="{{ old('job_title') }}"
                                class="form-control @error('job_title') is-invalid @enderror"
                                placeholder="Contoh: President"
                                required>
                            @error('job_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="min_salary" class="form-label fw-semibold">
                                Min Salary <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                name="min_salary"
                                id="min_salary"
                                value="{{ old('min_salary') }}"
                                class="form-control @error('min_salary') is-invalid @enderror"
                                placeholder="Contoh: 20000"
                                required>
                            @error('min_salary')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="max_salary" class="form-label fw-semibold">
                                Max Salary <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                name="max_salary"
                                id="max_salary"
                                value="{{ old('max_salary') }}"
                                class="form-control @error('max_salary') is-invalid @enderror"
                                placeholder="Contoh: 40000"
                                required>
                            @error('max_salary')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex gap-2 pt-3">
                            <button type="submit" class="btn btn-primary flex-fill">
                                Simpan
                            </button>
                            <a href="{{ route('jobs.index') }}" class="btn btn-outline-danger flex-fill">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
