<template>
    <div class="card card-compact max-w-full bg-base-100 shadow-xl">
        <figure>
            <img class="hotel__picture" :src="imageSrc" :alt="title" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">{{ title }}</h2>
            <p class="text-sm">{{ truncatedDescr }}</p>
            <p class="text-sm text-gray-700 leading-relaxed subpixel-antialiased italic">Адрес: {{ hotel.address }}</p>
            <HotelRating
                :rating="hotel.rating"
            />
            <div class="card-actions justify-end">
                <Link :href="route('hotels.get.current', { 'id': hotel.id })" as="button" class="btn btn-primary">Подробнее...</Link>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import HotelRating from "@/Components/Hotel/HotelRating.vue";
import truncateDescription from "@/helpers/truncateDescription.js";
import { NO_PHOTO_URL } from "@/dataConfig.js";

export default {
    name: "HotelItem",
    props: {
        hotel: Object,
    },
    components: {
        HotelRating,
        Link,
    },
    computed: {
        title() {
            return this.hotel.title.trim();
        },
        imageSrc() {
            return this.hotel.poster_url ? '/storage/' + this.hotel.poster_url : NO_PHOTO_URL;
        },
        truncatedDescr() {
            return truncateDescription(this.hotel.description.trim(), 100);
        }
    },
}
</script>

<style scoped>
.hotel__picture {
    width: 100%;
    height: 190px;
}
</style>
