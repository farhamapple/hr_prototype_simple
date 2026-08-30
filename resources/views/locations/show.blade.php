@extends('layouts.app')

@section('title', 'Detail Lokasi')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Lokasi</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('locations.index') }}">Data Lokasi</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $location->city }} (ID: {{ $location->location_id }})
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>Alamat</strong>
                            <div>{{ $location->street_address ?: '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Kode Pos</strong>
                            <div>{{ $location->postal_code ?: '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Kota</strong>
                            <div>{{ $location->city }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Provinsi / State</strong>
                            <div>{{ $location->state_province ?: '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Negara</strong>
                            <div>
                                @if ($location->country)
                                    {{ $location->country->country_name }}
                                    ({{ $location->country_id }})
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <strong>Wilayah</strong>
                            <div>{{ $location->country?->region?->region_name ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('locations.edit', $location) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pen-to-square me-1"></i>
                        Edit
                    </a>

                    <a href="{{ route('locations.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>

            {{-- Menampilkan departemen yang menggunakan location_id ini. --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Departemen pada Lokasi Ini</h3>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Departemen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($location->departments as $department)
                                    <tr>
                                        <td>{{ $department->department_id }}</td>
                                        <td>{{ $department->department_name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-3 text-body-secondary">
                                            Belum ada departemen yang menggunakan lokasi ini.
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
