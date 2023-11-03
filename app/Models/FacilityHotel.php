<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityHotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'facility_id',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function facilityHotel(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }
}
