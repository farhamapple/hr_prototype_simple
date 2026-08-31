@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Detail Karyawan</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Data Karyawan</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fa-solid fa-user me-2"></i>
                        {{ $employee->full_name }} (ID: {{ $employee->employee_id }})
                    </h3>
                </div>

                <div class="card-body">
                    {{-- Seluruh data detail berasal dari raw SELECT + JOIN di controller. --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>Email</strong>
                            <div>{{ $employee->email }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Phone</strong>
                            <div>{{ $employee->phone_number ?: '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Hire Date</strong>
                            <div>{{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Salary</strong>
                            <div>
                                {{ $employee->salary !== null ? number_format((float) $employee->salary, 2) : '-' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <strong>Job</strong>
                            <div>
                                {{ $employee->job_id }} - {{ $employee->job_title ?? '-' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <strong>Department</strong>
                            <div>
                                {{ $employee->department_name ?? '-' }}
                                @if ($employee->department_id)
                                    (ID: {{ $employee->department_id }})
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <strong>Manager</strong>
                            <div>{{ $employee->manager_name ?: '- (Top Level)' }}</div>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex flex-wrap gap-2">
                    <a
                        href="{{ route('employees.edit', $employee->employee_id) }}"
                        class="btn btn-warning"
                    >
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                    </a>

                    <form
                        action="{{ route('employees.destroy', $employee->employee_id) }}"
                        method="POST"
                        onsubmit="return confirm('Hapus data karyawan ini?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash me-1"></i> Hapus
                        </button>
                    </form>

                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Pekerjaan</h3>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Pekerjaan</th>
                                    <th>Departemen</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($jobHistory as $history)
                                    <tr>
                                        <td>
                                            {{ \Carbon\Carbon::parse($history->start_date)->format('d/m/Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($history->end_date)->format('d/m/Y') }}
                                        </td>
                                        <td>{{ $history->job_title ?? $history->job_id }}</td>
                                        <td>{{ $history->department_name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-body-secondary">
                                            Belum ada riwayat pekerjaan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
