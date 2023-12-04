import axios from "axios";

export function getBookedDates(room_id) {
    return axios.get(route('bookings.dates', { room_id: room_id}));
}

export function createBooking(params) {
    return axios.post(route('booking.store'), {
        params: {

        },
    });
}
