@extends('layouts.app')

@section('title', 'Jobs')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">DATA PEKERJAAN (JOBS)</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Jobs</li>
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

            <div class="card p-2 shadow-sm">
                <div class="card-header border-bottom py-2 d-flex flex-row-reverse">
                    <a href="{{ route('jobs.create') }}" class="btn btn-primary shadow-s">
                        + Tambah Job
                    </a>
                </div>
                <div class="card-body p-2">
                    <table class="table table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-left">Job ID</th>
                                <th class="text-left">Job Title</th>
                                <th class="text-center">Min</th>
                                <th class="text-center">Max</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-white">
                            @foreach($jobs as $job)
                            <tr>
                                <td class="fw-medium text-primary">{{ $job->job_id }}</td>
                                <td class="fw-semibold">{{ $job->job_title }}</td>
                                {{-- <td class="text-center">Rp {{ number_format($job->min_salary, 0, ',', '.') }}</td>
                                <td class="text-center">Rp {{ number_format($job->max_salary, 0, ',', '.') }}</td> --}}
                                <td class="text-center">{{ $job->min_salary }}</td>
                                <td class="text-center">{{ $job->max_salary }}</td>
                                <td class="text-center">
                                    <a href="{{ route('jobs.show', $job->job_id) }}" class="btn btn-sm btn-outline-info me-1">
                                        Detail
                                    </a>
                                    <a href="{{ route('jobs.edit', $job->job_id) }}" class="btn btn-sm btn-outline-warning me-1">
                                        Edit
                                    </a>
                                    <form action="{{ route('jobs.destroy', $job->job_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus job ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
