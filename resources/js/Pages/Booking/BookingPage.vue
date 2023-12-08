<template>
    <Head title="Забронированные"/>

    <AuthenticatedLayout>
        <template #header>
            <Link
                class="font-semibold text-xl text-gray-800 leading-tight mr-2"
                :href="route('main')"
                as="button"
            >
                Забронированные номера
            </Link>
        </template>
        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <VLoader
                class="pt-10"
                v-if="loadingStatus"
            />
            <BookingList
                v-else
                :bookings="bookings"
            />
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import BookingList from "@/Components/Booking/BookingList.vue";
import VLoader from "@/Components/VLoader.vue";

import { getBookings } from "@/api/bookingData.js";

export default {
    name: "BookingPage",
    data() {
        return {
            bookings: null,

            loadingStatus: false,
        }
    },
    components: {
        Link,
        AuthenticatedLayout,
        Head,
        BookingList,
        VLoader,
    },
    methods: {
        getUserBookings() {
            this.loadingStatus = true;

            getBookings()
                .then((response) => {
                    this.bookings = response.data;
                    this.loadingStatus = false;
                });
        },
    },
    created() {
        this.getUserBookings();
    }
}
</script>

<style scoped>

</style>
