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

    public function facilityHotel(): HasMany
    {
        return $this->hasMany(FacilityHotel::class);
    }

    public function facilityRoom(): HasMany
    {
        return $this->hasMany(FacilityRoom::class);
    }
}
