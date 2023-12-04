<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getBookedDates(Request $request, $room_id)
    {
        $bookedDates = Booking::findOrFail($room_id)->get(['started_at', 'finished_at'])->toArray();

        return response()->json($bookedDates);
    }

    public function createBooking(Request $request)
    {
        $validatedFields = $request->validate([
            'started_at' => ['required', 'date_format:Y-m-d'],
            'finished_at' => ['required', 'date_format:Y-m-d', 'after_or_equal:started_at'],
        ]);

        $roomPrice = Room::findOrFail($request->get('room_id'))->get(['price']);

        $startDate = Carbon::parse($validatedFields['started_at']);
        $endDate = Carbon::parse($validatedFields['finished_at']);

        $numberOfDays = $startDate->diffInDays($endDate);

        // ...... сделать валидацию на случай, если выбранные даты уже забронированы

        try {
            $booking = new Booking();

            $booking->user_id = $request->get('user_id');
            $booking->room_id = $request->get('room_id');
            $booking->started_at = $startDate;
            $booking->finished_at = $endDate;
            $booking->days = $numberOfDays;
            $booking->price = $roomPrice * $numberOfDays;

            $booking->save();

            return response()->json($booking, 201);
        } catch (ModelNotFoundException|\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }
}
