<template>
    <Head :title="hotel.title"/>

    <AuthenticatedLayout>
        <template #header>
            <Link
                class="font-semibold text-xl text-gray-800 leading-tight"
                :href="route('main')"
                as="button"
            >
                Отель "{{ hotel.title }}"
            </Link>
        </template>
        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col flex-nowrap">
            <VLoader
                v-if="showLoader"
            />

            <div class="m-full flex flex-row flex-nowrap justify-between mb-10" v-else>
                <div class="w-6/12">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4 py-2">
                        {{ hotel.title }}
                    </h2>
                    <img class="w-full" :src="hotelImage" :alt="hotel.title">
                </div>
                <div class="w-6/12 pl-10">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
                        Описание отеля
                    </h2>
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th class="w-4/12"></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-lg">Название номера:</td>
                                <td class="text-base">{{ hotel.title }}</td>
                            </tr>
                            <tr>
                                <td class="text-lg">Описание:</td>
                                <td class="text-base">{{ hotel.description }}</td>
                            </tr>
                            <tr>
                                <td class="text-lg">Адрес:</td>
                                <td class="text-base">{{ hotel.address }}</td>
                            </tr>
                            <tr>
                                <td class="text-lg">Рейтинг отеля:</td>
                                <td class="text-base">
                                    <HotelRating
                                        :rating="hotel.rating"
                                    />
                                </td>
                            </tr>
                            <tr v-show="facilities.length > 0">
                                <td class="text-lg">Удобства отеля:</td>
                                <td class="text-base">
                                    <ul>
                                        <FacilityItem
                                            v-for="facility in facilities"
                                            :key="facility.id"
                                            :facility="facility"
                                        />
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="m-full">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4 text-center">
                    Номера отеля
                </h2>
                <RoomList
                    :rooms="rooms"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from "@inertiajs/inertia-vue3";
import FacilityItem from "@/Components/Facility/FacilityItem.vue";
import HotelRating from "@/Components/Hotel/HotelRating.vue";
import RoomList from "@/Components/Room/RoomList.vue";
import VLoader from "@/Components/VLoader.vue";
import { NO_PHOTO_URL } from "@/dataConfig.js";

export default {
    name: "HotelPage",
    data() {
        return {
            showLoader: false,
        }
    },
    components: {
        RoomList,
        HotelRating,
        AuthenticatedLayout,
        Head,
        Link,
        FacilityItem,
        VLoader,
    },
    props: {
        hotelInfo: {
            type: Object,
            required: true,
        }
    },
    computed: {
        hotel() {
            return this.hotelInfo.hotelData;
        },
        rooms() {
            return this.hotelInfo.roomsData;
        },
        facilities() {
            return this.hotelInfo.hotelFacilities;
        },
        hotelImage() {
            return this.hotel.poster_url ? '/storage/' + this.hotel.poster_url : NO_PHOTO_URL;
        }
    },
}
</script>

<style scoped>

</style>
