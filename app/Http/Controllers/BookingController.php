<?php

namespace App\Http\Controllers;

use App\Notifications\BookingDetails;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Notifications\BookingConfirmation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    // Метод для получаения информации о забронированных номерах
    public function index(): \Illuminate\Http\JsonResponse
    {
        $bookingInfo = Booking::query()
            ->where('user_id', auth()->user()->id)
            ->with('room')
            ->get([
                'id',
                'room_id',
                'started_at',
                'finished_at',
                'days',
                'price',
                'status',
            ]);

        return response()->json($bookingInfo);
    }

    // Метод, отдающий массив забронированных дат на просматриваемом номере отеля
    public function getBookedDates(Request $request, $room_id): \Illuminate\Http\JsonResponse
    {
        $bookedDates = Booking::where('room_id', $room_id)
            ->get(['started_at', 'finished_at'])
            ->toArray();

        return response()->json($bookedDates);
    }

    /*
     * Метод для предварительного создания брони в БД
     * и отправки уведомления на почту пользователя с просьбой
     * подтвердить бронь номера
     */
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        $validatedFields = $request->validate([
            'room_id' => ['required'],
            'started_at' => ['required', 'date_format:Y-m-d'],
            'finished_at' => ['required', 'date_format:Y-m-d', 'after_or_equal:started_at'],
        ]);

        $roomPrice = Room::findOrFail($validatedFields['room_id'])->value('price');

        // Парсинг строки даты в объект даты
        $startDate = Carbon::parse($validatedFields['started_at']);
        $endDate = Carbon::parse($validatedFields['finished_at']);

        // Количетсво дней (включительно (+1))
        $numberOfDays = $startDate->diffInDays($endDate) + 1;

        // Цена бронирования за период
        $currentPrice = $roomPrice * ($numberOfDays);

        // Проверка на пересечение дат бронирования номера
        $existingBookings = Booking::where('room_id', $validatedFields['room_id'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where('started_at', '<=', $endDate)
                    ->where('finished_at', '>=', $startDate)
                    ->where('status', '<>', 'pending');
            })
            ->get();

        if ($existingBookings->isNotEmpty()) {
            return response()->json([
                'errors' => [
                    'message' => 'Выбранные даты уже забронированы',
                ],
            ], 422);
        }

        try {
            $booking = new Booking();

            $booking->user_id = $user->id;
            $booking->room_id = $validatedFields['room_id'];
            $booking->started_at = $startDate;
            $booking->finished_at = $endDate;
            $booking->days = $numberOfDays;
            $booking->price = $currentPrice;
            $booking->status = 'pending';

            $booking->save();

            // Отправка уведомления на почту о необходимости подвердить бронирование
            Notification::route('mail', $user->email)->notify(new BookingConfirmation($booking, $user->id));

            return response()->json([
                'message' => 'Пожалуйста, проверьте вашу почту для подтверждения брони. Бронь необходимо подтвердить в течение 10 минут.',
            ], 201);
        } catch (ModelNotFoundException|\Exception $exception) {
            return response()->json([
                'errors' => $exception->getMessage(),
            ], 500);
        }
    }

    // Метод для подтверждения бронирования номера отеля
    public function confirm(Request $request, $bookingId, $userId): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::findOrFail($userId);
        $booking = Booking::findOrFail($bookingId);
        $room = $booking->room;

        if ($booking->status === 'pending') {

            $booking->update(['status' => 'confirmed']);

            try {
                Notification::route('mail', $user->email)->notify(new BookingDetails($booking, $user, $room));
            } catch (\Exception $exception) {
                return response()->json([
                    'errors' => $exception->getMessage(),
                ], 500);
            }

            return view('booking-confirmed');
        }

        return view('booking-error');
    }

    // Метод для отмены бронирования
    public function cancel(Request $request, $booking_id): \Illuminate\Http\JsonResponse
    {
        try {
            $booking = Booking::findOrFail($booking_id);

            if ($booking->status !== 'canceled') {
                $booking->update(['status' => 'canceled']);

                return response()->json([
                    'message' => 'Бронирование успешно отменено.',
                ]);
            }

            return response()->json([
                'error' => 'Бронирование уже отменено.',
            ], 422);
        } catch (\Exception $exception) {
            return response()->json([
                'errors' => $exception->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request, $booking_id): \Illuminate\Http\JsonResponse
    {
        try {
            Booking::findOrFail($booking_id)->delete();

            return response()->json([
                'message' => 'Бронь была удалена'
            ], 204);
        } catch (\Exception $exception) {
            return response()->json([
                'errors' => $exception->getMessage(),
            ], 500);
        }

    }
}
