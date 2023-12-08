import axios from "axios";

export function getBookedDates(room_id) {
    return axios.get(route('bookings.dates', { room_id: room_id}));
}

export function createBooking(params) {
    return axios.post(route('booking.store'), {
        'room_id': params.room_id,
        'started_at': params.started_at,
        'finished_at': params.finished_at,
    });
}

export function getBookings() {
    return axios.get(route('bookings.info'));
}
