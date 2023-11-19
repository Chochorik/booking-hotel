<template>
    <div class="rating rating-md">
        <input
            v-for="rating in rating"
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
</template>

<script>
export default {
    name: "HotelRating",
    props: {
        rating: Number,
    },
    computed: {
        incompleteRating() {
            return 5 - this.rating;
        }
    }
}
</script>

<style scoped>

</style>
