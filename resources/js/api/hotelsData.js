import axios from "axios";

export function getAllHotels(params) {
    return axios.get(route('hotels.get.all'), {
        params: {
            'page': params.page,
            'priceFrom': params.priceFrom,
            'priceTo': params.priceTo,
            'facilities': params.facilities,
            'rating': params.rating,
        }
    });
}
