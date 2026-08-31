<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Menampilkan daftar data karyawan.
     */
    public function index(Request $request)
    {
        // Mengambil employee sekaligus relasi yang dibutuhkan pada tabel.
        $employees = Employee::with(['job', 'department'])
            ->when($request->filled('search'), function ($query) use ($request) {
                // ILIKE dipakai karena database menggunakan PostgreSQL agar pencarian tidak case-sensitive.
                $search = $request->string('search')->trim()->value();

                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'ILIKE', "%{$search}%")
                        ->orWhere('last_name', 'ILIKE', "%{$search}%")
                        ->orWhere('email', 'ILIKE', "%{$search}%");
                });
            })
            ->when($request->filled('department_id'), function ($query) use ($request) {
                // Filter employee berdasarkan department yang dipilih.
                $query->where('department_id', $request->integer('department_id'));
            })
            ->orderBy('employee_id')
            ->paginate(10)
            ->withQueryString();

        // Data department digunakan untuk pilihan filter.
        $departments = Department::orderBy('department_name')->get();

        return view('employees.index', compact('employees', 'departments'));
    }

    /**
     * Menampilkan form tambah karyawan.
     */
    public function create()
    {
        return view('employees.create', $this->formData());
    }

    /**
     * Menyimpan data karyawan baru.
     */
    public function store(Request $request)
    {
        // Input diperiksa terlebih dahulu sebelum disimpan ke database.
        $validated = $request->validate($this->validationRules());

        // Tabel HR tidak menggunakan sequence/auto increment untuk employee_id.
        // Untuk prototype ini ID berikutnya diambil dari employee_id terbesar + 1.
        $validated['employee_id'] = (Employee::max('employee_id') ?? 0) + 1;

        Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail karyawan beserta riwayat pekerjaannya.
     */
    public function show(Employee $employee)
    {
        // load() mengambil relasi hanya untuk employee yang sedang dibuka.
        $employee->load([
            'job',
            'department',
            'manager',
            'jobHistory.job',
            'jobHistory.department',
        ]);

        return view('employees.show', compact('employee'));
    }

    /**
     * Menampilkan form edit karyawan.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', [
            'employee' => $employee,
            ...$this->formData($employee),
        ]);
    }

    /**
     * Memperbarui data karyawan.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate($this->validationRules($employee));

        // update() hanya mengubah record employee yang sedang dipilih.
        $employee->update($validated);

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus data karyawan jika tidak sedang dipakai oleh relasi lain.
     */
    public function destroy(Employee $employee)
    {
        // Foreign key mencegah employee yang masih menjadi manager atau memiliki riwayat dihapus.
        $isReferenced = $employee->subordinates()->exists()
            || $employee->jobHistory()->exists()
            || Department::where('manager_id', $employee->employee_id)->exists();

        if ($isReferenced) {
            return back()->with(
                'error',
                'Data karyawan tidak dapat dihapus karena masih digunakan pada data lain.'
            );
        }

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }

    /**
     * Menyiapkan data dropdown yang dipakai form tambah dan edit.
     */
    private function formData(?Employee $employee = null): array
    {
        $managers = Employee::orderBy('first_name')
            ->orderBy('last_name')
            ->when($employee, function ($query) use ($employee) {
                // Employee tidak boleh dipilih sebagai manager untuk dirinya sendiri.
                $query->where('employee_id', '!=', $employee->employee_id);
            })
            ->get();

        return [
            'jobs' => Job::orderBy('job_title')->get(),
            'departments' => Department::orderBy('department_name')->get(),
            'managers' => $managers,
        ];
    }

    /**
     * Aturan validasi bersama untuk proses tambah dan edit.
     */
    private function validationRules(?Employee $employee = null): array
    {
        // Saat edit, email milik employee yang sedang diedit tidak dianggap duplikat.
        $emailRule = Rule::unique('employees', 'email');

        if ($employee) {
            $emailRule->ignore($employee->employee_id, 'employee_id');
        }

        return [
            'first_name' => ['nullable', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'max:25', $emailRule],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'hire_date' => ['required', 'date'],
            'job_id' => ['required', 'exists:jobs,job_id'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'manager_id' => ['nullable', 'exists:employees,employee_id'],
            'department_id' => ['nullable', 'exists:departments,department_id'],
        ];
    }
}
