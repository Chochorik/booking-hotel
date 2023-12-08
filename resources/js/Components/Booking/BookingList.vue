<template>
    <div class="w-full overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th class="text-lg">Номер</th>
                    <th class="text-lg">Заселение</th>
                    <th class="text-lg">Выселение</th>
                    <th class="text-lg">Длительность</th>
                    <th class="text-lg">Стоимость</th>
                    <th class="text-lg">Статус</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-lg font-normal">
                <BookingItem
                    v-for="booking in bookings"
                    :key="booking.id"
                    :booking="booking"
                />
            </tbody>
        </table>
    </div>
</template>

<script>
import BookingItem from "@/Components/Booking/BookingItem.vue";

export default {
    name: "BookingList",
    components: {
        BookingItem,
    },
    props: {
        bookings: {
            type: Array,
            default: [],
        },
    },
}
</script>

<style scoped>

</style>
