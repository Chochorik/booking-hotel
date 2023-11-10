<template>
    <div class="card card-compact max-w-full bg-base-100 shadow-xl">
        <figure>
            <img class="mx-auto" :src="imageSrc" :alt="hotelTitle" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">{{ hotelTitle }}</h2>
            <p>{{ hotel.description }}</p>
            <div class="card-actions justify-end">
                <button class="btn btn-primary">Подробнее...</button>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
    name: "HotelItem",
    props: {
        hotel: Object,
    },
    components: {
        Link,
    },
    computed: {
        imageSrc() {
            return 'storage/' + this.hotel.poster_url;
        },
        hotelTitle() {
            return this.hotel.title;
        },
    }
}
</script>

<style scoped>

</style>
