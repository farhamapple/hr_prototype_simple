<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
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

        $managers = DB::select("
            SELECT employee_id, CONCAT(first_name, ' ', last_name) AS full_name 
            FROM employees 
            ORDER BY first_name ASC
        ");

        $locations = DB::select("
            SELECT location_id, city 
            FROM locations 
            ORDER BY city ASC
        ");

        return view('departments.index', compact('departments', 'managers', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'manager_id'      => 'nullable|exists:employees,employee_id',
            'location_id'     => 'nullable|exists:locations,location_id',
        ]);

        $maxId = DB::table('departments')->max('department_id') ?? 0;
        $newId = $maxId + 10;
        DB::table('departments')->insert([
        'department_id'   => $newId,
        'department_name' => $request->department_name,
        'manager_id'      => $request->manager_id,
        'location_id'     => $request->location_id,
        ]);

        // DB::insert("
        //     INSERT INTO departments (department_name, manager_id, location_id) 
        //     VALUES (?, ?, ?)
        // ", [
        //     $request->department_name,
        //     $request->manager_id ?: null,
        //     $request->location_id ?: null
        // ]);
        
        return redirect()->back()->with('success', 'Departemen berhasil ditambahkan!');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'manager_id'      => 'nullable|exists:employees,employee_id',
            'location_id'     => 'nullable|exists:locations,location_id',
        ]);

        DB::update("
            UPDATE departments 
            SET department_name = ?, manager_id = ?, location_id = ? 
            WHERE department_id = ?
        ", [
            $request->department_name,
            $request->manager_id ?: null,
            $request->location_id ?: null,
            $id
        ]);

        return redirect()->back()->with('success', 'Departemen berhasil diperbarui!');
    }

    
    public function destroy($id)
    {
        DB::delete("DELETE FROM departments WHERE department_id = ?", [$id]);

        return redirect()->back()->with('success', 'Departemen berhasil dihapus!');
    }
}