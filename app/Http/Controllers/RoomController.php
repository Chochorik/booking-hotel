<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function getRoom(int $id): \Inertia\Response
    {
        $room = Room::query()->findOrFail($id);

        return Inertia::render('Room/RoomPage', [
            'roomData' => [
                'room' => $room,
                'facilities' => $room->facilitiesOfRoom,
                'hotelName' => $room->hotel->title,
            ],
        ]);
    }
}
