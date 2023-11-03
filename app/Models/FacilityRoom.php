<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'facility_id',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function facilityRoom(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }
}
