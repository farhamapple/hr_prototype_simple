<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'country_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'country_id');
    }
}
