@extends('layouts.app')

@section('title', 'Data Lokasi')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Lokasi</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Data Lokasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            {{-- Feedback setelah proses create, update, atau delete. --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <h3 class="card-title mb-0">Daftar Lokasi</h3>

                        <a href="{{ route('locations.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-1"></i>
                            Tambah Lokasi
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    {{-- GET dipakai agar parameter search/filter tetap terlihat di URL. --}}
                    <form action="{{ route('locations.index') }}" method="GET" class="row g-2 mb-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control"
                                    placeholder="Cari alamat, kota, provinsi..."
                                >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <select name="country_id" class="form-select">
                                <option value="">Semua Negara</option>

                                @foreach ($countries as $country)
                                    <option
                                        value="{{ $country->country_id }}"
                                        @selected(
                                            (string) request('country_id')
                                            === (string) $country->country_id
                                        )
                                    >
                                        {{ $country->country_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa-solid fa-magnifying-glass me-1"></i>
                                Cari
                            </button>

                            <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary">
                                Reset
                            </a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 90px;">ID</th>
                                    <th>Alamat</th>
                                    <th>Kota</th>
                                    <th>Provinsi</th>
                                    <th>Kode Pos</th>
                                    <th>Negara</th>
                                    <th class="text-center" style="width: 130px;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($locations as $location)
                                    <tr>
                                        <td>{{ $location->location_id }}</td>
                                        <td>{{ $location->street_address ?: '-' }}</td>
                                        <td>{{ $location->city }}</td>
                                        <td>{{ $location->state_province ?: '-' }}</td>
                                        <td>{{ $location->postal_code ?: '-' }}</td>
                                        <td>
                                            @if ($location->country)
                                                {{ $location->country->country_name }}
                                                <small class="text-body-secondary">
                                                    ({{ $location->country_id }})
                                                </small>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a
                                                    href="{{ route('locations.show', $location) }}"
                                                    class="btn btn-outline-info"
                                                    title="Detail"
                                                >
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                <a
                                                    href="{{ route('locations.edit', $location) }}"
                                                    class="btn btn-outline-warning"
                                                    title="Edit"
                                                >
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                <form
                                                    action="{{ route('locations.destroy', $location) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus lokasi ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-danger rounded-start-0"
                                                        title="Hapus"
                                                    >
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-body-secondary">
                                            Data lokasi tidak ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($locations->hasPages())
                    <div class="card-footer">
                        {{ $locations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
