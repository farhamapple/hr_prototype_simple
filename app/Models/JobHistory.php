<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobHistory extends Model
{
    // Nama tabel database berbentuk singular, jadi ditentukan secara eksplisit.
    protected $table = 'job_history';

    // Tabel job_history tidak memiliki kolom created_at dan updated_at.
    public $timestamps = false;

    // Tabel menggunakan kombinasi employee_id dan start_date,
    // sehingga tidak ada satu primary key Eloquent yang digunakan.
    protected $primaryKey = null;

    public $incrementing = false;

    /**
     * Riwayat pekerjaan dimiliki oleh satu employee.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Riwayat pekerjaan mengacu ke satu job.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /**
     * Riwayat pekerjaan dapat mengacu ke satu department.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
