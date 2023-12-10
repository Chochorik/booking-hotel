<template>
    <table class="table text-base">
        <tbody>
            <tr>
                <td>
                    Номер
                </td>
                <td>
                    <Link
                        :href="route('room.get.current', { id: booking.room_id })"
                        as="a"
                    >
                        {{ booking.room.title }}
                    </Link>
                </td>
            </tr>

            <tr>
                <td>
                    Период
                </td>
                <td>
                    {{ 'с ' + booking.started_at + ' по ' + booking.finished_at }}
                </td>
            </tr>

            <tr>
                <td>
                    Дни
                </td>
                <td>
                    {{ booking.days }}
                </td>
            </tr>

            <tr>
                <td>
                    Стоимость
                </td>
                <td>
                    {{ priceFormat(booking.price) }} ₽
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import priceFormat from "@/helpers/priceFormat.js";
import { Link } from "@inertiajs/vue3";

export default {
    name: "RoomModalTable",
    components: {
        Link,
    },
    props: {
        booking: {
            type: Object,
            required: true,
        },
    },
    methods: {
        priceFormat,
    },
}
</script>

<style scoped>

</style>
