@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Negara</h3>
    
    <form action="{{ route('countries.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">ID Negara (2 Karakter)</label>
            <input type="text" name="country_id" class="form-control" maxlength="2" required placeholder="Contoh: ID, US, JP">
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Negara</label>
            <input type="text" name="country_name" class="form-control" required placeholder="Contoh: Indonesia">
        </div>

        <div class="mb-3">
            <label class="form-label">Region</label>
            <select name="region_id" class="form-select" required>
                <option value="">-- Pilih Region --</option>
                @foreach($regions as $r)
                    <option value="{{ $r->region_id }}">{{ $r->region_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('countries.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection