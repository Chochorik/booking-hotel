import axios from "axios";

export function getAllFacilities() {
    return axios.get('/facilities');
}
