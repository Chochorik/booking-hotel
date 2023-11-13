<template>
    <div class="card card-compact max-w-full bg-base-100 shadow-xl">
        <figure>
            <img class="hotel__picture" :src="imageSrc" :alt="title" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">{{ title }}</h2>
            <p class="text-sm">{{ truncatedDescr }}</p>
            <p class="text-sm text-gray-700 leading-relaxed subpixel-antialiased italic">Адрес: {{ hotel.address }}</p>
            <div class="rating rating-md">
                <input
                    v-for="rating in hotel.rating"
                    :key="rating"
                    type="radio"
                    class="mask mask-star-2 bg-orange-400"
                    disabled
                />
                <input
                    v-for="rating in incompleteRating"
                    :key="rating"
                    type="radio"
                    class="mask mask-star-2 bg-gray-300"
                    disabled
                />
            </div>
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
        title() {
            return this.hotel.title.trim();
        },
        imageSrc() {
            return 'storage/' + this.hotel.poster_url;
        },
        truncatedDescr() {
            return this.truncate(this.hotel.description.trim(), 100,);
        },
        incompleteRating() {
            return 5 - this.hotel.rating;
        }
    },
    methods: {
        truncate(str, n){
            return (str.length > n) ? str.slice(0, n-1) + '...' : str;
        },
    }
}
</script>

<style scoped>
.hotel__picture {
    width: 100%;
    height: 190px;
}
</style>
