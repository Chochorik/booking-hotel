<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use http\Env\Request;

class HotelController extends Controller
{
    public function showAll(): \Illuminate\Http\JsonResponse
    {
        $hotels = Hotel::paginate(9);

        return response()->json($hotels);
    }

    public function showHotel(Hotel $hotel): \Illuminate\Http\JsonResponse
    {
        return response()->json($hotel);
    }
}
