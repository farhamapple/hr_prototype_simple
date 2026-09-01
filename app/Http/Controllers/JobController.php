<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $jobs = Job::withCount('employees')->get();
        $jobs = DB::select('
            select j.* , count(e.employee_id ) as employees_count 
                from jobs j
                left join employees e
                on j.job_id  = e.job_id
                group by j.job_id
                order by j.job_id  asc
        ');
        return view('jobs.jobs-index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.jobs-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id'        => 'required|string|max:50|uppercase|unique:jobs,job_id',
            'job_title'     => 'required|string|max:255|unique:jobs,job_title',
            'min_salary'    => 'required|numeric|min:0',
            'max_salary'    => 'required|numeric|min:0|gte:min_salary',
        ], [
            'job_id.unique'     => 'Job ID ini sudah ada, silakan buat yang lain.',
            'job_title.unique'  => 'Job Title ini sudah ada, silakan buat yang lain.',
            'max_salary.gte'    => 'Gaji maksimal harus lebih besar atau sama dengan gaji minimal.',
        ]);
        
        // Job::create($validated);
        DB::insert('
            insert into jobs (job_id, job_title, min_salary, max_salary)
            values (?, ?, ?, ?)
        ', [
            $validated['job_id'],
            $validated['job_title'],
            $validated['min_salary'],
            $validated['max_salary']
        ]);
        
        return redirect()
            ->route('jobs.index')
            ->with('success', 'Pekerjaan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view('jobs.jobs-show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jobResults = DB::select('SELECT * FROM jobs WHERE job_id = ?', [$id]);
        
        if (empty($jobResults)) {
            abort(404);
        }

        $job = $jobResults[0];

        return view('jobs.jobs-edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
                'job_id' => [
                'required',
                'string',
                'max:50',
                'uppercase',
                Rule::unique('jobs', 'job_id')->ignore($id, 'job_id') // Abaikan ID saat ini
            ],
            'job_title'  => [
                'required',
                'string',
                'max:255',
                Rule::unique('jobs', 'job_title')->ignore($id, 'job_id')
            ],
            'min_salary'    => 'required|numeric|min:0',
            'max_salary'    => 'required|numeric|min:0|gte:min_salary',
        ], [
            'job_id.unique'     => 'Job ID ini sudah ada.',
            'job_title.unique'  => 'Job Title ini sudah ada.',
            'max_salary.gte'    => 'Gaji maksimal harus lebih besar atau sama dengan gaji minimal.',
        ]);
        
        // $job->update($validated);
        DB::update('
            update jobs
            set job_id = ?, job_title = ?, min_salary = ?, max_salary = ?
            where job_id = ?
        ', [
            $validated['job_id'],
            $validated['job_title'],
            $validated['min_salary'],
            $validated['max_salary'],
            $id
        ]);
        
        return redirect()
            ->route('jobs.index')
            ->with('success', 'Pekerjaan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $connectedDataJob = DB::table('employees')
        ->where('job_id', $id)
        ->exists();
        
        if ($connectedDataJob) {
            return redirect()
                ->route('jobs.index')
                ->with('warning', 'Pekerjaan tidak bisa dihapus karena masih ada data yang terhubung! Hapus data yang terkait terlebih dahulu di data karyawan.');
        }

        // $job->delete();
        DB::delete('delete from jobs where job_id = ?', [$id]);
    
        return redirect()
            ->route('jobs.index')
            ->with('success', 'Pekerjaan berhasil dihapus!');
    }
}
