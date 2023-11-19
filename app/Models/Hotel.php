<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'address',
    ];

    public function room(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function facilityHotel(): HasMany
    {
        return $this->hasMany(FacilityHotel::class);
    }

    public function facilitiesOfHotel(): HasManyThrough
    {
        return $this->hasManyThrough(Facility::class, FacilityHotel::class, 'hotel_id', 'id', 'id', 'facility_id');
    }
}
