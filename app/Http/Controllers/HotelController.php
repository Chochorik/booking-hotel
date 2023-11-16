<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HotelController extends Controller
{
    public function showAll(Request $request): \Illuminate\Http\JsonResponse
    {
        $priceFrom = $request->get('priceFrom');
        $priceTo = $request->get('priceTo');
        $facilities = $request->get('facilities');
        $rating = $request->get('rating');

        $query = Hotel::query();

        // Поиск по цене в таблице rooms
        if ($priceFrom || $priceTo) {
            $query->whereHas('room', function ($roomsQuery) use ($priceFrom, $priceTo) {
                $roomsQuery->whereBetween('price', [$priceFrom, $priceTo]);
            });
        }

        // Поиск по удобствам в таблице facility_hotels
        if (!empty($facilities)) {
            $query->whereHas('facilityHotel', function ($facilityQuery) use ($facilities) {
                $facilityQuery->whereIn('facility_id', $facilities);
            });
        }

        // Поиск по рейтингу
        if ($rating) {
            $query->where('rating', $rating);
        }

        $hotels = $query->paginate(9);

        return response()->json($hotels);
    }

    public function showHotel(int $id): \Inertia\Response
    {
        $hotel = Hotel::query()->findOrFail($id);

        return Inertia::render('Hotel/HotelPage', [
            'hotelInfo' => [
                'hotelData' => $hotel,
                'roomsData' => $hotel->room,
            ],
        ]);
    }
}
