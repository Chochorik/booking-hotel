<template>
    <tr>
        <th class="font-normal">
            {{ room.title }}
        </th>
        <th class="font-normal">
            {{ booking.started_at }}
        </th>
        <th class="font-normal">
            {{ booking.finished_at }}
        </th>
        <th class="font-normal">
            {{ pluralizationDays(booking.days) }}
        </th>
        <th class="font-normal">
            {{ priceFormat(booking.price) }} ₽
        </th>
        <th
            :class="{
                'status-confirmed': booking.status === 'confirmed',
                'status-pending': booking.status === 'pending',
                'status-canceled': booking.status === 'canceled'
            }"
        >
            {{ bookingStatus }}
        </th>
        <th>
            <button class="btn btn-active btn-primary" @click.prevent="showModal">
                Подробнее
            </button>
        </th>
    </tr>
</template>

<script>
import priceFormat from "@/helpers/priceFormat.js";
import pluralizationDays from "@/helpers/pluralizationDays.js";
import RoomModal from "@/Components/Room/RoomModal.vue";

export default {
    name: "BookingItem",
    data() {
        return {
            showRoomModal: false,
        }
    },
    components: {
        RoomModal,
    },
    props: {
        booking: {
            type: Object,
            required: true,
            default: {},
        },
    },
    computed: {
        room() {
            return this.booking.room;
        },
        bookingStatus() {
            if (this.booking.status === 'pending') {
                return 'Не подтвержден';
            } else if (this.booking.status === 'confirmed') {
                return 'Подтвержден';
            }

            return 'Отменен';
        },
    },
    methods: {
        priceFormat,
        pluralizationDays,
        showModal() {
            this.$emit('show-modal', this.booking);
        },
    }
}
</script>

<style scoped>
.status-confirmed {
    color: #0ebd2e;
}

.status-pending {
    color: #ea0000;
}

.status-canceled {
    color: #645091;
}
</style>
