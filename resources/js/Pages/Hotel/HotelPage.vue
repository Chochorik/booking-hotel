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
            <div class="m-full flex flex-row flex-nowrap justify-between">
                <div class="w-6/12">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ hotel.title }}
                    </h2>
                    <img :src="hotelImage" :alt="hotel.title">
                </div>
                <div class="w-6/12">

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from "@inertiajs/inertia-vue3";

export default {
    name: "HotelPage",
    components: {
        AuthenticatedLayout,
        Head,
        Link,
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
        hotelImage() {
            return 'storage/' + this.hotel.poster_url;
        }
    }
}
</script>

<style scoped>

</style>
