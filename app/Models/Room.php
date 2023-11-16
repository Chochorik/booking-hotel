<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    /**
     * @var mixed|string
     */
    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'floor_area',
        'hotel_id',
        'type',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function facilityRoom(): HasMany
    {
        return $this->hasMany(FacilityRoom::class);
    }

    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
