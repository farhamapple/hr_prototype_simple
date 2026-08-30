@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- Judul halaman --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Data Karyawan
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Daftar karyawan yang tersimpan pada database HR.
        </p>
    </div>

    {{-- Tabel data karyawan --}}
    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">
                        ID
                    </th>

                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">
                        Nama
                    </th>

                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">
                        Email
                    </th>

                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">
                        Pekerjaan
                    </th>

                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">
                        Departemen
                    </th>

                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">
                        Gaji
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">

                {{-- Melakukan perulangan untuk setiap data karyawan --}}
                @forelse ($employees as $employee)

                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $employee->employee_id }}
                        </td>

                        <td class="px-4 py-3 text-sm font-medium text-gray-800">
                            {{ $employee->full_name }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $employee->email }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{-- optional() mencegah error jika relasi job kosong --}}
                            {{ optional($employee->job)->job_title ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{-- Jika employee belum memiliki departemen, tampilkan tanda "-" --}}
                            {{ optional($employee->department)->department_name ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ number_format($employee->salary ?? 0, 2) }}
                        </td>
                    </tr>

                @empty

                    {{-- Ditampilkan jika data employee kosong --}}
                    <tr>
                        <td colspan="6"
                            class="px-4 py-6 text-center text-sm text-gray-500">

                            Belum ada data karyawan.

                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Navigasi pagination --}}
    <div class="mt-5">
        {{ $employees->links() }}
    </div>

</div>
@endsection