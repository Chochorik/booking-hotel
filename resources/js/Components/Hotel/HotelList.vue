<template>
    <ul v-if="hotelsList.length > 0" class="catalog__list grid grid-cols-3 gap-4">
        <HotelItem
            v-for="hotel in hotelsList"
            :key="hotel.id"
            :hotel="hotel"
        />
    </ul>
    <p class="text-lg" v-else>
        Кажется, ничего не найдено...
    </p>
</template>

<script>
import HotelItem from "@/Components/Hotel/HotelItem.vue";

export default {
    name: "HotelList",
    components: {
        HotelItem,
    },
    props: {
        hotels: Object,
    },
    computed: {
        hotelsList() {
            return this.hotels.data || [];
        },
    },
}
</script>

<style lang="scss" scoped>
</style>
