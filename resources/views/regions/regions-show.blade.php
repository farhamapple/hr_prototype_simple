@extends('layouts.app')

@section('title', 'Regions')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">DETAIL WILAYAH</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('regions.index') }}">Regions</a></li>
                        <li class="breadcrumb-item active">Detail Region</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card p-4 shadow-sm">
                <div class="card-body p-4">
                    <div class="">
                        
                        <div class="col-md-6">
                            <label class="d-block text-muted small text-uppercase fw-bold mb-2">Nama Wilayah</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $region->region_name }}</p>
                        </div>
                        
                    </div>
                    
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('regions.edit', $region->region_id) }}" class="btn btn-warning flex-fill text-white fw-semibold py-2">
                            Edit
                        </a>
                        <form action="{{ route('regions.destroy', $region->region_id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Apakah Anda yakin ingin menghapus region ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 fw-semibold py-2">
                                Hapus
                            </button>
                        </form>
                        <a href="{{ route('regions.index', $region->region_id) }}" class="btn btn-outline-secondary flex-fill fw-semibold py-2">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
