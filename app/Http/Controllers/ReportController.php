<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = DB::select('
        select d.department_id, d.department_name, count(e.employee_id ) as jml_karyawan, avg(e.salary ) as rata_rata_gaji
            from employees e
                left join
                    departments d on e.department_id = d.department_id
                group by d.department_id
                order by jml_karyawan  asc
        ');
        return view('reports.employees-by-department-index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $dept = DB::select("
        select
            d.department_id,
            d.department_name,
            m.first_name || ' ' || m.last_name as nama_manager,
            l.street_address
            from departments d
            left join employees m on d.manager_id = m.employee_id
            left join locations l on d.location_id = l.location_id
            where d.department_id = ?
        ", [$id]);

        if (empty($dept)) {
            abort(404);
        }
        $report = $dept[0];

        $report->employees = DB::select("
        select
            e.employee_id,
            e.first_name || ' ' || e.last_name as employee_name,
            e.job_id,
            j.job_title,
            e.salary
            from employees e
            left join jobs j on e.job_id  = j.job_id
            where e.department_id = ?
            order by e.employee_id asc
        ", [$id]);
    
        return view('reports.employees-by-department-show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
