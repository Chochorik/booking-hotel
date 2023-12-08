<template>
    <tr>
        <th>
            {{ room.title }}
        </th>
        <th>
            {{ booking.started_at }}
        </th>
        <th>
            {{ booking.finished_at }}
        </th>
        <th>
            {{ pluralizationDays(booking.days) }}
        </th>
        <th>
            {{ priceFormat(booking.price) }} ₽
        </th>
        <th>
            {{ bookingStatus }}
        </th>
        <th>
            <button class="btn btn-active btn-primary">
                Подробнее...
            </button>
        </th>
    </tr>
</template>

<script>
import priceFormat from "@/helpers/priceFormat.js";
import pluralizationDays from "@/helpers/pluralizationDays.js";

export default {
    name: "BookingItem",
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

            return 'Истек';
        },
    },
    methods: {
        priceFormat,
        pluralizationDays,
    }
}
</script>

<style scoped>

</style>
