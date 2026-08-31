<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Menampilkan daftar data karyawan.
     */
    public function index(Request $request)
    {
        // Nilai search dan filter dibaca dari query string.
        $search = trim((string) $request->input('search', ''));
        $departmentId = trim((string) $request->input('department_id', ''));

        $conditions = [];
        $bindings = [];

        if ($search !== '') {
            // ILIKE digunakan PostgreSQL agar pencarian tidak case-sensitive.
            $conditions[] = '(
                e.first_name ILIKE ?
                OR e.last_name ILIKE ?
                OR e.email ILIKE ?
            )';

            $keyword = "%{$search}%";
            array_push($bindings, $keyword, $keyword, $keyword);
        }

        if ($departmentId !== '') {
            // Tanda ? adalah parameter binding, sehingga input tidak ditempel langsung ke SQL.
            $conditions[] = 'e.department_id = ?';
            $bindings[] = (int) $departmentId;
        }

        // WHERE hanya ditambahkan jika search atau filter digunakan.
        $whereSql = $conditions
            ? 'WHERE '.implode(' AND ', $conditions)
            : '';

        // Menghitung total data untuk pagination.
        $total = DB::selectOne(
            "SELECT COUNT(*) AS total
             FROM employees e
             {$whereSql}",
            $bindings
        )->total;

        $perPage = 10;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $offset = ($page - 1) * $perPage;

        // Raw SELECT dengan JOIN untuk mengambil job dan department.
        $employees = DB::select(
            "SELECT
                e.employee_id,
                e.first_name,
                e.last_name,
                CONCAT_WS(' ', e.first_name, e.last_name) AS full_name,
                e.email,
                e.job_id,
                e.salary,
                j.job_title,
                d.department_name
             FROM employees e
             LEFT JOIN jobs j
                ON e.job_id = j.job_id
             LEFT JOIN departments d
                ON e.department_id = d.department_id
             {$whereSql}
             ORDER BY e.employee_id
             LIMIT ? OFFSET ?",
            [...$bindings, $perPage, $offset]
        );

        // DB::select() menghasilkan array, jadi paginator dibuat manual.
        $employees = new LengthAwarePaginator(
            $employees,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        // Dropdown department juga diambil menggunakan raw query.
        $departments = DB::select(
            'SELECT department_id, department_name
             FROM departments
             ORDER BY department_name'
        );

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
        $validated = $this->validateEmployee($request);

        // employee_id tidak menggunakan auto increment pada database HR.
        $nextId = DB::selectOne(
            'SELECT COALESCE(MAX(employee_id), 0) + 1 AS next_id
             FROM employees'
        )->next_id;

        // INSERT ditulis langsung menggunakan raw query.
        DB::insert(
            'INSERT INTO employees (
                employee_id,
                first_name,
                last_name,
                email,
                phone_number,
                hire_date,
                job_id,
                salary,
                commission_pct,
                manager_id,
                department_id
             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $nextId,
                $validated['first_name'] ?? null,
                $validated['last_name'],
                $validated['email'],
                $validated['phone_number'] ?? null,
                $validated['hire_date'],
                $validated['job_id'],
                $validated['salary'] ?? null,
                null,
                $validated['manager_id'] ?? null,
                $validated['department_id'] ?? null,
            ]
        );

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail karyawan beserta riwayat pekerjaannya.
     */
    public function show(int $employee)
    {
        // JOIN dipakai untuk mengambil data job, department, dan manager dalam satu query.
        $employeeData = DB::selectOne(
            "SELECT
                e.employee_id,
                e.first_name,
                e.last_name,
                CONCAT_WS(' ', e.first_name, e.last_name) AS full_name,
                e.email,
                e.phone_number,
                e.hire_date,
                e.job_id,
                e.salary,
                e.department_id,
                e.manager_id,
                j.job_title,
                d.department_name,
                CONCAT_WS(' ', m.first_name, m.last_name) AS manager_name
             FROM employees e
             LEFT JOIN jobs j
                ON e.job_id = j.job_id
             LEFT JOIN departments d
                ON e.department_id = d.department_id
             LEFT JOIN employees m
                ON e.manager_id = m.employee_id
             WHERE e.employee_id = ?",
            [$employee]
        );

        abort_if(!$employeeData, 404);

        // Riwayat pekerjaan diambil dari job_history beserta relasi job dan department.
        $jobHistory = DB::select(
            'SELECT
                jh.start_date,
                jh.end_date,
                jh.job_id,
                jh.department_id,
                j.job_title,
                d.department_name
             FROM job_history jh
             LEFT JOIN jobs j
                ON jh.job_id = j.job_id
             LEFT JOIN departments d
                ON jh.department_id = d.department_id
             WHERE jh.employee_id = ?
             ORDER BY jh.start_date DESC',
            [$employee]
        );

        return view('employees.show', [
            'employee' => $employeeData,
            'jobHistory' => $jobHistory,
        ]);
    }

    /**
     * Menampilkan form edit karyawan.
     */
    public function edit(int $employee)
    {
        // Data employee yang akan diedit diambil berdasarkan primary key.
        $employeeData = DB::selectOne(
            'SELECT
                employee_id,
                first_name,
                last_name,
                email,
                phone_number,
                hire_date,
                job_id,
                salary,
                manager_id,
                department_id
             FROM employees
             WHERE employee_id = ?',
            [$employee]
        );

        abort_if(!$employeeData, 404);

        return view('employees.edit', [
            'employee' => $employeeData,
            ...$this->formData($employee),
        ]);
    }

    /**
     * Memperbarui data karyawan.
     */
    public function update(Request $request, int $employee)
    {
        abort_unless($this->employeeExists($employee), 404);

        $validated = $this->validateEmployee($request, $employee);

        // UPDATE dilakukan langsung ke tabel employees.
        DB::update(
            'UPDATE employees
             SET
                first_name = ?,
                last_name = ?,
                email = ?,
                phone_number = ?,
                hire_date = ?,
                job_id = ?,
                salary = ?,
                manager_id = ?,
                department_id = ?
             WHERE employee_id = ?',
            [
                $validated['first_name'] ?? null,
                $validated['last_name'],
                $validated['email'],
                $validated['phone_number'] ?? null,
                $validated['hire_date'],
                $validated['job_id'],
                $validated['salary'] ?? null,
                $validated['manager_id'] ?? null,
                $validated['department_id'] ?? null,
                $employee,
            ]
        );

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus data karyawan jika tidak sedang dipakai data lain.
     */
    public function destroy(int $employee)
    {
        abort_unless($this->employeeExists($employee), 404);

        // Semua pengecekan foreign key dilakukan dengan raw query.
        $subordinateCount = DB::selectOne(
            'SELECT COUNT(*) AS total
             FROM employees
             WHERE manager_id = ?',
            [$employee]
        )->total;

        $historyCount = DB::selectOne(
            'SELECT COUNT(*) AS total
             FROM job_history
             WHERE employee_id = ?',
            [$employee]
        )->total;

        $managedDepartmentCount = DB::selectOne(
            'SELECT COUNT(*) AS total
             FROM departments
             WHERE manager_id = ?',
            [$employee]
        )->total;

        if (
            $subordinateCount > 0
            || $historyCount > 0
            || $managedDepartmentCount > 0
        ) {
            return back()->with(
                'error',
                'Data karyawan tidak dapat dihapus karena masih digunakan pada data lain.'
            );
        }

        // DELETE dilakukan langsung berdasarkan employee_id.
        DB::delete(
            'DELETE FROM employees
             WHERE employee_id = ?',
            [$employee]
        );

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }

    /**
     * Menyiapkan data dropdown untuk form tambah dan edit.
     */
    private function formData(?int $currentEmployeeId = null): array
    {
        $managerSql = "SELECT
                employee_id,
                CONCAT_WS(' ', first_name, last_name) AS full_name
             FROM employees";

        $managerBindings = [];

        if ($currentEmployeeId !== null) {
            // Employee tidak boleh menjadi manager untuk dirinya sendiri.
            $managerSql .= ' WHERE employee_id <> ?';
            $managerBindings[] = $currentEmployeeId;
        }

        $managerSql .= ' ORDER BY first_name, last_name';

        return [
            'jobs' => DB::select(
                'SELECT job_id, job_title
                 FROM jobs
                 ORDER BY job_title'
            ),
            'departments' => DB::select(
                'SELECT department_id, department_name
                 FROM departments
                 ORDER BY department_name'
            ),
            'managers' => DB::select($managerSql, $managerBindings),
        ];
    }

    /**
     * Validasi form dan pengecekan relasi menggunakan raw query.
     */
    private function validateEmployee(
        Request $request,
        ?int $currentEmployeeId = null
    ): array {
        // Rule dasar hanya memeriksa format input.
        $validator = Validator::make($request->all(), [
            'first_name' => ['nullable', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'max:25'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'hire_date' => ['required', 'date'],
            'job_id' => ['required', 'string', 'max:10'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'manager_id' => ['nullable', 'integer'],
            'department_id' => ['nullable', 'integer'],
        ]);

        $validator->after(function ($validator) use ($request, $currentEmployeeId) {
            // Email harus unik. Saat edit, ID employee saat ini dikecualikan.
            $emailSql = 'SELECT COUNT(*) AS total
                         FROM employees
                         WHERE email = ?';
            $emailBindings = [$request->input('email')];

            if ($currentEmployeeId !== null) {
                $emailSql .= ' AND employee_id <> ?';
                $emailBindings[] = $currentEmployeeId;
            }

            $emailCount = DB::selectOne($emailSql, $emailBindings)->total;

            if ($emailCount > 0) {
                $validator->errors()->add(
                    'email',
                    'Email sudah digunakan oleh karyawan lain.'
                );
            }

            // job_id wajib benar-benar ada di tabel jobs.
            if ($request->filled('job_id')) {
                $jobExists = DB::selectOne(
                    'SELECT EXISTS(
                        SELECT 1 FROM jobs WHERE job_id = ?
                     ) AS exists',
                    [$request->input('job_id')]
                )->exists;

                if (!$jobExists) {
                    $validator->errors()->add(
                        'job_id',
                        'Job yang dipilih tidak valid.'
                    );
                }
            }

            // department_id bersifat nullable, tetapi jika diisi harus valid.
            if ($request->filled('department_id')) {
                $departmentExists = DB::selectOne(
                    'SELECT EXISTS(
                        SELECT 1
                        FROM departments
                        WHERE department_id = ?
                     ) AS exists',
                    [(int) $request->input('department_id')]
                )->exists;

                if (!$departmentExists) {
                    $validator->errors()->add(
                        'department_id',
                        'Department yang dipilih tidak valid.'
                    );
                }
            }

            // manager_id juga nullable dan harus menunjuk employee lain.
            if ($request->filled('manager_id')) {
                $managerId = (int) $request->input('manager_id');

                if ($currentEmployeeId !== null && $managerId === $currentEmployeeId) {
                    $validator->errors()->add(
                        'manager_id',
                        'Karyawan tidak dapat menjadi manager untuk dirinya sendiri.'
                    );
                }

                $managerExists = DB::selectOne(
                    'SELECT EXISTS(
                        SELECT 1
                        FROM employees
                        WHERE employee_id = ?
                     ) AS exists',
                    [$managerId]
                )->exists;

                if (!$managerExists) {
                    $validator->errors()->add(
                        'manager_id',
                        'Manager yang dipilih tidak valid.'
                    );
                }
            }
        });

        return $validator->validate();
    }

    /**
     * Mengecek employee berdasarkan primary key menggunakan raw query.
     */
    private function employeeExists(int $employeeId): bool
    {
        return DB::selectOne(
            'SELECT EXISTS(
                SELECT 1
                FROM employees
                WHERE employee_id = ?
             ) AS exists',
            [$employeeId]
        )->exists;
    }
}
