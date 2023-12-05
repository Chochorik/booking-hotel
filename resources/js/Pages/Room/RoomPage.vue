<template>
    <Head :title="room.title"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-items-center content-center">
                <Link
                    class="font-semibold text-xl text-gray-800 leading-tight mr-2"
                    :href="route('hotels.get.current', { 'id': room.hotel_id })"
                    as="button"
                >
                    Отель "{{ roomData.hotelName }}"
                </Link>
                <div class="arrow mr-2">
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M4 12L8 8M4 12L8 16" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
                <p class="font-semibold text-xl text-gray-800 leading-tight mt-0.5">
                    Номер "{{ room.title }}"
                </p>
            </div>
        </template>

        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="m-full flex flex-row flex-nowrap justify-between mb-7">
                <div class="w-6/12">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4 py-2">
                        {{ room.title }}
                    </h2>
                    <img class="w-full" :src="roomImage" :alt="room.title">
                </div>
                <div class="w-6/12 pl-10">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
                        Характеристики номера
                    </h2>
                    <table class="table table-zebra mb-10">
                        <thead>
                            <tr>
                                <th class="w-4/12"></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-lg">Название номера:</td>
                                <td class="text-base">{{ room.title }}</td>
                            </tr>
                            <tr>
                                <td class="text-lg">Тип номера:</td>
                                <td class="text-base">{{ room.type }}</td>
                            </tr>
                            <tr>
                                <td class="text-lg">Площадь номера:</td>
                                <td class="text-base">{{ room.floor_area }} м<sup>2</sup></td>
                            </tr>
                            <tr>
                                <td class="text-lg">Стоимость номера (за ночь):</td>
                                <td class="text-base">{{ priceFormat(room.price) }} </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary text-lg px-10" @click="showModal">
                        Забронировать
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <p class="text-2xl">Описание:</p>
                <p class="text-lg">{{ room.description }}</p>
            </div>
            <div v-show="facilities.length > 0" class="mb-4">
                    <p class="text-2xl">Удобства отеля:</p>
                    <ul class="text-lg">
                        <FacilityItem
                            v-for="facility in facilities"
                            :key="facility.id"
                            :facility="facility"
                        />
                    </ul>
            </div>
            <BookingModal
                v-model:showBookingModal="showBookingModal"
                :data="room"
            />
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FacilityItem from "@/Components/Facility/FacilityItem.vue";
import { Head } from '@inertiajs/vue3';
import { NO_PHOTO_URL } from "@/dataConfig.js";
import BookingModal from "@/Components/Booking/BookingModal.vue";
import priceFormat from "@/helpers/priceFormat.js";

export default {
    name: "RoomPage",
    data() {
        return {
            showBookingModal: false,
        }
    },
    components: {
        AuthenticatedLayout,
        Head,
        Link,
        FacilityItem,
        BookingModal,
    },
    props: {
        roomData: {
            type: Object,
            required: true,
        },
    },
    computed: {
        room() {
            return this.roomData.room ? this.roomData.room : {};
        },
        facilities() {
            return this.roomData.facilities;
        },
        roomImage() {
            return this.room.poster_url ? '/storage/' + this.room.poster_url : NO_PHOTO_URL;
        },
    },
    methods: {
        priceFormat,
        showModal() {
            this.showBookingModal = !this.showBookingModal;
        },
    }
}
</script>

<style scoped>

</style>
