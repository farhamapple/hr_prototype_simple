<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class JobHistoryController extends Controller
{
    public function index()
    {
        $employees = DB::select('
            select distinct
                e.employee_id,
                concat_ws(\' \', e.first_name, e.last_name) as employee_name
            from job_history jh
            join employees e
                on jh.employee_id = e.employee_id
            order by e.employee_id
        ');

        return view('job-history.index', compact('employees'));
    }

    public function show($employeeId)
    {
        $employee = DB::selectOne('
            select
                employee_id,
                concat_ws(\' \', first_name, last_name) as employee_name
            from employees
            where employee_id = ?
        ', [$employeeId]);

        abort_if(!$employee, 404);

        $histories = DB::select('
            select
                jh.start_date,
                jh.end_date,
                j.job_title,
                d.department_name
            from job_history jh
            left join jobs j
                on jh.job_id = j.job_id
            left join departments d
                on jh.department_id = d.department_id
            where jh.employee_id = ?
            order by jh.start_date desc
        ', [$employeeId]);

        return view('job-history.show', compact('employee', 'histories'));
    }
}
