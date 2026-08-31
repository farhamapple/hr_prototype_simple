<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'job_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'job_id');
    }

    protected $fillable = [
        'job_id',
        'job_title',
        'min_salary',
        'max_salary',
    ];
}
