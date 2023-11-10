<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import HotelList from "@/Components/Hotel/HotelList.vue";
import HotelFilter from "@/Components/Hotel/HotelFilter.vue";
import axios from "axios";

export default {
    data() {
        return {
            filterPriceFrom: 0,
            filterPriceTo: 0,
            filterFacilities: [],
            filterStars: 0,

            hotelsData: Object,
            page: 1,
            totalPages: Number,
        }
    },
    components: {
        AuthenticatedLayout,
        Head,
        HotelFilter,
        HotelList,
    },
    methods: {
        getHotels() {
            axios.get('/hotels/all', {
                params: {
                    'page': this.page,
                },
            })
                .then((response) => {
                    this.hotelsData = response.data;
                    this.totalPages = response.data.total;
                })
        }
    },
    created() {
        this.getHotels();
    }
}
</script>

<template>
    <Head title="Hotels"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Отели</h2>
        </template>

        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-row flex-nowrap">
            <HotelFilter class="basis-1/4"/>
            <HotelList class="basis-4/5" :hotels="hotelsData" />
        </div>
    </AuthenticatedLayout>
</template>
