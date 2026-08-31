@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Karyawan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Data Karyawan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            {{-- Feedback setelah proses CRUD. --}}
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

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <h3 class="card-title mb-0">Daftar Karyawan</h3>
                        <a href="{{ route('employees.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Karyawan
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    {{-- GET dipakai agar keyword/filter tetap terlihat pada URL dan pagination. --}}
                    <form action="{{ route('employees.index') }}" method="GET" class="row g-2 mb-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control"
                                    placeholder="Cari nama atau email..."
                                >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <select name="department_id" class="form-select">
                                <option value="">Semua Departemen</option>
                                @foreach ($departments as $department)
                                    <option
                                        value="{{ $department->department_id }}"
                                        @selected((string) request('department_id') === (string) $department->department_id)
                                    >
                                        {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                            </button>
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Job ID</th>
                                    <th>Pekerjaan</th>
                                    <th class="text-end">Gaji</th>
                                    <th>Departemen</th>
                                    <th class="text-center" style="width: 170px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->employee_id }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $employee->full_name }}</div>
                                            <small class="text-body-secondary">{{ $employee->email }}</small>
                                        </td>
                                        <td>{{ $employee->job_id }}</td>
                                        <td>{{ $employee->job?->job_title ?? '-' }}</td>
                                        <td class="text-end">
                                            {{ $employee->salary !== null ? number_format((float) $employee->salary, 2) : '-' }}
                                        </td>
                                        <td>{{ $employee->department?->department_name ?? '-' }}</td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('employees.show', $employee) }}" class="btn btn-outline-info" title="Detail">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form
                                                    action="{{ route('employees.destroy', $employee) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Hapus data karyawan ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger rounded-start-0" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-body-secondary">
                                            Data karyawan tidak ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($employees->hasPages())
                    <div class="card-footer d-flex justify-content-center">
                        {{-- Bootstrap paginator mencegah ikon SVG pagination membesar seperti sebelumnya. --}}
                        {{ $employees->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
