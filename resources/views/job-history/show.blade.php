@extends('layouts.app')

@section('title', 'Detail Riwayat Pekerjaan')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">RIWAYAT PEKERJAAN KARYAWAN</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('job-history.index') }}">Riwayat Pekerjaan</a>
                        </li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $employee->employee_name }} (ID: {{ $employee->employee_id }})
                    </h3>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Mulai Kerja</th>
                                    <th>Selesai Kerja</th>
                                    <th>Pekerjaan</th>
                                    <th>Nama Departemen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($histories as $history)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($history->start_date)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($history->end_date)->format('d/m/Y') }}</td>
                                        <td>{{ $history->job_title ?? '-' }}</td>
                                        <td>{{ $history->department_name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">
                                            Riwayat pekerjaan karyawan belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('job-history.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
