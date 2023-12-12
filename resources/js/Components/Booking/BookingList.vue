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
            <tbody class="text-lg">
                <BookingItem
                    v-for="booking in bookings"
                    :key="booking.id"
                    :booking="booking"
                    @show-modal="showModal"
                />
            </tbody>
        </table>
        <RoomModal
            v-if="selectedBooking"
            v-model:show-room-modal="showRoomModal"
            :booking="selectedBooking"
            @close-modal="closeModal"
            @booking-cancelled="handleBookingCancelled"
        />
    </div>
</template>

<script>
import BookingItem from "@/Components/Booking/BookingItem.vue";
import RoomModal from "@/Components/Room/RoomModal.vue";

export default {
    name: "BookingList",
    data() {
        return {
            selectedBooking: null,

            showRoomModal: false,
        }
    },
    components: {
        BookingItem,
        RoomModal,
    },
    props: {
        bookings: {
            type: Array,
            default: [],
        },
    },
    methods: {
        showModal(booking) {
            this.selectedBooking = booking;
            this.showRoomModal = true;
        },
        closeModal() {
            this.selectedBooking = null;
            this.showRoomModal = false;
        },
        handleBookingCancelled() {
            this.$emit('booking-cancelled');
        },
    },
    watch: {
        bookings(newBookings) {
            this.selectedBooking = newBookings.length > 0 ? newBookings[0] : null;
        },
    },
}
</script>

<style scoped>

</style>
