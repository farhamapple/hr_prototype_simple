<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use App\Models\Location;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalDepartments = Department::count();
        $totalLocations = Location::count();
        $totalJobs = Job::count();

        $employeesPerDepartment = Department::query()
            ->withCount('employees')
            ->orderByDesc('employees_count')
            ->limit(10)
            ->get()
            ->map(fn ($d) => [
                'label' => $d->department_name,
                'value' => $d->employees_count,
            ]);

        $employeesPerRegion = DB::table('employees')
            ->join('departments', 'employees.department_id', '=', 'departments.department_id')
            ->join('locations', 'departments.location_id', '=', 'locations.location_id')
            ->join('countries', 'locations.country_id', '=', 'countries.country_id')
            ->join('regions', 'countries.region_id', '=', 'regions.region_id')
            ->selectRaw('regions.region_name as label, COUNT(*) as value')
            ->groupBy('regions.region_name')
            ->orderByDesc('value')
            ->get();

        return view('dashboard', compact(
            'totalEmployees',
            'totalDepartments',
            'totalLocations',
            'totalJobs',
            'employeesPerDepartment',
            'employeesPerRegion',
        ));
    }
}
