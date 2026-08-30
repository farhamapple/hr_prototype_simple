@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Negara</h3>
    
    <form action="{{ route('countries.update', $country->country_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">ID Negara</label>
            <input type="text" class="form-control" value="{{ $country->country_id }}" disabled>
            <small class="text-muted">*ID Negara tidak dapat diubah (Primary Key)</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Negara</label>
            <input type="text" name="country_name" class="form-control" value="{{ $country->country_name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Region</label>
            <select name="region_id" class="form-select" required>
                <option value="">-- Pilih Region --</option>
                @foreach($regions as $r)
                    <option value="{{ $r->region_id }}" {{ $country->region_id == $r->region_id ? 'selected' : '' }}>
                        {{ $r->region_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('countries.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection