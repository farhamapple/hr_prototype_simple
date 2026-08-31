@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Edit Karyawan</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Data Karyawan</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Karyawan #{{ $employee->employee_id }}</h3>
                </div>

                {{-- PUT digunakan untuk memperbarui employee yang sudah ada. --}}
                <form action="{{ route('employees.update', $employee->employee_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input id="first_name" type="text" name="first_name"
                                    value="{{ old('first_name', $employee->first_name) }}"
                                    class="form-control @error('first_name') is-invalid @enderror" maxlength="20">
                                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input id="last_name" type="text" name="last_name"
                                    value="{{ old('last_name', $employee->last_name) }}"
                                    class="form-control @error('last_name') is-invalid @enderror" maxlength="25" required>
                                @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input id="email" type="text" name="email"
                                    value="{{ old('email', $employee->email) }}"
                                    class="form-control @error('email') is-invalid @enderror" maxlength="25" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Phone</label>
                                <input id="phone_number" type="text" name="phone_number"
                                    value="{{ old('phone_number', $employee->phone_number) }}"
                                    class="form-control @error('phone_number') is-invalid @enderror" maxlength="20">
                                @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="hire_date" class="form-label">Hire Date <span class="text-danger">*</span></label>
                                <input id="hire_date" type="date" name="hire_date"
                                    value="{{ old('hire_date', $employee->hire_date) }}"
                                    class="form-control @error('hire_date') is-invalid @enderror" required>
                                @error('hire_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="job_id" class="form-label">Job <span class="text-danger">*</span></label>
                                <select id="job_id" name="job_id" class="form-select @error('job_id') is-invalid @enderror" required>
                                    <option value="">Pilih Job</option>
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job->job_id }}" @selected(old('job_id', $employee->job_id) == $job->job_id)>
                                            {{ $job->job_id }} - {{ $job->job_title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('job_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="department_id" class="form-label">Department</label>
                                <select id="department_id" name="department_id" class="form-select @error('department_id') is-invalid @enderror">
                                    <option value="">Pilih Departemen</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->department_id }}" @selected(old('department_id', $employee->department_id) == $department->department_id)>
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="manager_id" class="form-label">Manager</label>
                                <select id="manager_id" name="manager_id" class="form-select @error('manager_id') is-invalid @enderror">
                                    <option value="">Tidak Ada Manager</option>
                                    @foreach ($managers as $manager)
                                        <option value="{{ $manager->employee_id }}" @selected(old('manager_id', $employee->manager_id) == $manager->employee_id)>
                                            {{ $manager->employee_id }} - {{ $manager->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('manager_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="salary" class="form-label">Salary</label>
                                <input id="salary" type="number" name="salary"
                                    value="{{ old('salary', $employee->salary) }}"
                                    class="form-control @error('salary') is-invalid @enderror" min="0" step="0.01">
                                @error('salary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('employees.show', $employee->employee_id) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
