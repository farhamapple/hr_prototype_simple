<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Departemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
    <div class="container bg-white p-4 rounded shadow-sm">
        <h3 class="mb-4">DATA DEPARTEMEN</h3>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Tambah Data Baru -->
        <form action="{{ route('departments.store') }}" method="POST" class="row g-3 mb-4">
            @csrf
            <div class="col-md-3">
                <input type="text" name="department_name" class="form-control" placeholder="Nama Departemen" required>
            </div>
            <div class="col-md-3">
                <select name="manager_id" class="form-select">
                    <option value="">-- Pilih Manager (Opsional) --</option>
                    @foreach($managers as $m)
                        <option value="{{ $m->employee_id }}">{{ $m->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="location_id" class="form-select">
                    <option value="">-- Pilih Lokasi (Opsional) --</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->location_id }}">{{ $loc->city }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">+ Tambah</button>
            </div>
        </form>

        <!-- Tabel Tampil Data -->
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Departemen</th>
                    <th>Manager</th>
                    <th>Lokasi</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                <tr>
                    <td>{{ $dept->department_id }}</td>
                    <td>{{ $dept->department_name }}</td>
                    <td>{{ $dept->manager_name ?? '-' }}</td>
                    <td>{{ $dept->location ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $dept->department_id }}">
                                Edit
                            </button>

                            <form action="{{ route('departments.destroy', $dept->department_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus departemen ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>

                        <!-- Modal Edit Data -->
                        <div class="modal fade" id="editModal{{ $dept->department_id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('departments.update', $dept->department_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Departemen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Departemen</label>
                                                <input type="text" name="department_name" class="form-control" value="{{ $dept->department_name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Manager</label>
                                                <select name="manager_id" class="form-select">
                                                    <option value="">-- Tanpa Manager --</option>
                                                    @foreach($managers as $m)
                                                        <option value="{{ $m->employee_id }}" {{ $dept->manager_id == $m->employee_id ? 'selected' : '' }}>
                                                            {{ $m->full_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Lokasi</label>
                                                <select name="location_id" class="form-select">
                                                    <option value="">-- Tanpa Lokasi --</option>
                                                    @foreach($locations as $loc)
                                                        <option value="{{ $loc->location_id }}" {{ $dept->location_id == $loc->location_id ? 'selected' : '' }}>
                                                            {{ $loc->city }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data departemen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>