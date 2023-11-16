<template>
    <Head title="Отели"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Отели</h2>
        </template>

        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-row flex-nowrap">
            <HotelFilter
                class="basis-1/4"
                v-model:price-from="filterPriceFrom"
                v-model:price-to="filterPriceTo"
                v-model:rating="filterRating"
                v-model:facilities="filterFacilities"
            />
            <div class="flex flex-col items-center basis-3/4">
                <HotelList class="mb-6" :hotels="hotelsData" />
                <HotelPagination
                    v-model:page="page"
                    :count="hotelsData.total"
                    :per-page="hotelsData.per_page"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import HotelList from "@/Components/Hotel/HotelList.vue";
import HotelFilter from "@/Components/Hotel/HotelFilter.vue";
import HotelPagination from "@/Components/Hotel/HotelPagination.vue";
import { getAllHotels } from "@/api/hotelsData.js";

export default {
    data() {
        return {
            filterPriceFrom: 0,
            filterPriceTo: 0,
            filterFacilities: [],
            filterRating: 0,

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
        HotelPagination,
    },
    methods: {
        getHotels() {
            getAllHotels({
                page: this.page,
                priceFrom: this.filterPriceFrom,
                priceTo: this.filterPriceTo,
                facilities: this.filterFacilities,
                rating: this.filterRating,
            })
                .then((response) => {
                    this.hotelsData = response.data;
                    this.totalPages = response.data.total;
                });
        }
    },
    watch: {
        page() {
            this.getHotels();
        },
        filterPriceFrom() {
            this.getHotels();
        },
        filterPriceTo() {
            this.getHotels();
        },
        filterFacilities() {
            this.getHotels();
        },
        filterRating() {
            this.getHotels();
        }
    },
    created() {
        this.getHotels();
    }
}
</script>
