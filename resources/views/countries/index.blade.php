@extends('layouts.app') {{-- sesuaikan dengan layout kamu --}}

@section('content')
<div class="container">
    <h3>Data Negara</h3>
    <a href="{{ route('countries.create') }}" class="btn btn-primary mb-3">Tambah Negara</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Negara</th>
                <th>Region</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $c)
            <tr>
                <td>{{ $c->country_id }}</td>
                <td>{{ $c->country_name }}</td>
                <td>{{ $c->region_name ?? '-' }}</td>
                <td>
                    <a href="{{ route('countries.edit', $c->country_id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('countries.destroy', $c->country_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection