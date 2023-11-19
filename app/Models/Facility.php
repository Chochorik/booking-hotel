<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'laravel_through_key'
    ];

    public function facilitiesHotel(): HasMany
    {
        return $this->hasMany(FacilityHotel::class);
    }

    public function facilityRoom(): HasMany
    {
        return $this->hasMany(FacilityRoom::class);
    }
}
