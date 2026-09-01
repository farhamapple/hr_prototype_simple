@extends('layouts.app')

@section('title', 'Regions')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">TAMBAH WILAYAH BARU</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('regions.index') }}">Regions</a></li>
                        <li class="breadcrumb-item active">Tambah Region</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card p-4 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('regions.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="region_id" class="form-label fw-semibold">
                                ID <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                name="region_id"
                                id="region_id"
                                value="{{ old('region_id') }}"
                                class="form-control @error('region_id') is-invalid @enderror"
                                placeholder="Contoh: 1"
                                required>
                            @error('region_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="region_name" class="form-label fw-semibold">
                                Nama Wilayah <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                name="region_name"
                                id="region_name"
                                value="{{ old('region_name') }}"
                                class="form-control @error('region_name') is-invalid @enderror"
                                placeholder="Contoh: Asia"
                                required>
                            @error('region_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex gap-2 pt-3">
                            <button type="submit" class="btn btn-primary flex-fill">
                                Simpan
                            </button>
                            <a href="{{ route('regions.index') }}" class="btn btn-outline-danger flex-fill">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
