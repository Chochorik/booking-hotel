<template>
    <div class="absolute z-40" v-show="showBookingModal">
        <dialog id="my_modal_4" class="modal opacity-100">
            <div class="modal-box w-11/12 max-w-5xl">
                <h2 class="font-bold text-3xl mb-2">Бронирование номера</h2>
                <p class="text-xl">
                    Данные номера:
                </p>
                <div>
                    <VDatePicker
                        v-model.range.string="datesRange"
                        :masks="masks"
                        :color="datePickerColor"
                        :min-date="minDate"
                        :disabled-dates="bookedDates"
                        is-required
                    />
                </div>
                <div class="modal-action">
                    <button class="btn" @click.prevent="closeModal">Закрыть</button>
                </div>
            </div>
        </dialog>
        <div class="fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-50"></div>
    </div>
</template>

<script>
import { getBookedDates } from "@/api/bookingData.js";

export default {
    name: "BookingModal",
    data() {
        return {
            datesRange: null,
            minDate: new Date(),
            bookedDates: [],
            datePickerColor: 'purple',
            masks: {
                modelValue: 'YYYY-MM-DD',
            },
        }
    },
    props: {
        showBookingModal: {
            type: Boolean,
            default: false,
        },
        data: {
            type: Object,
            required: true,
        },
    },
    methods: {
        closeModal() {
            this.$emit('update:showBookingModal', false);
        },
        getBooking() {
            getBookedDates(this.data.id)
                .then((response) => {
                    this.bookedDates = response.data.map(({ started_at, finished_at }) => [started_at, finished_at]);
                })
        },
    },
    created() {
        this.getBooking();
    }
}
</script>

<style scoped>
.modal {
    pointer-events: all;
}
</style>
