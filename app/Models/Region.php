<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Region extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'region_id';

    public $incrementing = false;

    public function countries(): HasMany
    {
        return $this->hasMany(Country::class, 'region_id');
    }

    protected $fillable = [
        'region_id',
        'region_name',
    ];
}
