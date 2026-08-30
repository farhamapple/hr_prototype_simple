<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Menampilkan daftar data karyawan.
     */
    public function index()
    {
        // Mengambil data karyawan beserta relasi job dan department.
        // with() digunakan agar data relasi tidak dipanggil berulang-ulang.
        $employees = Employee::with(['job', 'department'])
            ->orderBy('employee_id')
            ->paginate(10);

        // Mengirim data karyawan ke halaman employees/index.blade.php.
        return view('employees.index', compact('employees'));
    }
}