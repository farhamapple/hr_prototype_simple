<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    // READ: Menampilkan data dengan JOIN ke employees dan locations
    public function index()
    {
        // Pastikan d.manager_id dan d.location_id juga ditarik agar bisa dipakai di form modal Edit
        $departments = DB::select("
            SELECT 
                d.department_id,
                d.department_name,
                d.manager_id,
                d.location_id,
                CONCAT(e.first_name, ' ', e.last_name) AS manager_name,
                l.city AS location
            FROM departments d
            LEFT JOIN employees e ON d.manager_id = e.employee_id
            LEFT JOIN locations l ON d.location_id = l.location_id
            ORDER BY d.department_id ASC
        ");

        return view('departments.index', compact('departments'));
    }

    // CREATE: Insert data departemen baru via Raw SQL
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'manager_id'      => 'nullable|integer',
            'location_id'     => 'nullable|integer',
        ]);

        DB::insert("
            INSERT INTO departments (department_name, manager_id, location_id, created_at, updated_at) 
            VALUES (?, ?, ?, NOW(), NOW())
        ", [
            $request->department_name,
            $request->manager_id ?: null,
            $request->location_id ?: null
        ]);

        return redirect()->back()->with('success', 'Departemen berhasil ditambahkan!');
    }

    // UPDATE: Update data departemen via Raw SQL
    public function update(Request $request, $id)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'manager_id'      => 'nullable|integer',
            'location_id'     => 'nullable|integer',
        ]);

        DB::update("
            UPDATE departments 
            SET department_name = ?, manager_id = ?, location_id = ?, updated_at = NOW() 
            WHERE department_id = ?
        ", [
            $request->department_name,
            $request->manager_id ?: null,
            $request->location_id ?: null,
            $id
        ]);

        return redirect()->back()->with('success', 'Departemen berhasil diperbarui!');
    }

    // DELETE: Hapus data departemen via Raw SQL
    public function destroy($id)
    {
        DB::delete("DELETE FROM departments WHERE department_id = ?", [$id]);

        return redirect()->back()->with('success', 'Departemen berhasil dihapus!');
    }
}