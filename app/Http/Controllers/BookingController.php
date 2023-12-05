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
            'room_id' => ['required'],
            'started_at' => ['required', 'date_format:Y-m-d'],
            'finished_at' => ['required', 'date_format:Y-m-d', 'after_or_equal:started_at'],
        ]);

        $roomPrice = Room::findOrFail($validatedFields['room_id'])->value('price');

        $startDate = Carbon::parse($validatedFields['started_at']);
        $endDate = Carbon::parse($validatedFields['finished_at']);

        $numberOfDays = $startDate->diffInDays($endDate);

        $currentPrice = $roomPrice * ($numberOfDays + 1);

        $existingBookings = Booking::where('room_id', $validatedFields['room_id'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('started_at', [$startDate, $endDate])
                    ->orWhereBetween('finished_at', [$startDate, $endDate])
                    ->orWhere('started_at', $startDate)
                    ->orWhere('finished_at', $endDate);
            })
            ->get();

        if ($existingBookings->isNotEmpty()) {
            return response()->json([
                'errors' => [
                    'message' => 'Выбранные даты уже забронированы.',
                ],
            ], 422);
        }

        try {
            $booking = new Booking();

            $booking->user_id = auth()->user()->id;
            $booking->room_id = $validatedFields['room_id'];
            $booking->started_at = $startDate;
            $booking->finished_at = $endDate;
            $booking->days = $numberOfDays;
            $booking->price = $currentPrice;

            $booking->save();

            return response()->json($booking, 201);
        } catch (ModelNotFoundException|\Exception $exception) {
            return response()->json([
                'errors' => $exception->getMessage(),
            ], 500);
        }
    }
}
