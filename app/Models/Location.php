<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'location_id';

    public $incrementing = false;

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'location_id');
    }
}
