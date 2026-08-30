<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    // Tabel locations pada database HR tidak memiliki created_at dan updated_at.
    public $timestamps = false;

    // Primary key tabel locations bukan "id", tetapi "location_id".
    protected $primaryKey = 'location_id';

    // location_id pada database HR tidak menggunakan auto increment.
    public $incrementing = false;

    // Field yang boleh diisi melalui create() dan update().
    protected $fillable = [
        'location_id',
        'street_address',
        'postal_code',
        'city',
        'state_province',
        'country_id',
    ];

    /**
     * Satu lokasi berada pada satu negara.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Satu lokasi dapat digunakan oleh banyak departemen.
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'location_id');
    }
}
