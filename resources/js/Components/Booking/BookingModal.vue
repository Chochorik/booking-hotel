<template>
    <Modal :show="showBookingModal">
        <form @submit.prevent="postBooking" class="opacity-100 p-10 min-h-[550px] flex flex-col justify-between">
            <div class="w-full">
                <h2 class="font-bold text-3xl mb-2">Бронирование номера</h2>
                <p class="text-2xl mb-4">
                    Данные номера:
                </p>
                <div class="flex flex-col justify-center items-center booking-container">
                    <div class="w-full mb-10">
                        <h2 class="text-xl mb-2">
                            Выберите период пребывания
                        </h2>
                        <VDatePicker
                            class="z-40"
                            v-model.range.string="datesRange"
                            :masks="masks"
                            :color="datePickerColor"
                            :min-date="minDate"
                            :disabled-dates="bookedDates"
                            is-required
                        >
                            <template #default="{ inputValue, inputEvents }">
                                <div class="grid grid-cols-2 gap-4 justify-between items-center">
                                    <div class="flex flex-col justify-center items-left">
                                        <InputLabel value="Начало:" />
                                        <InputDefault :model-value="inputValue.start" v-on="inputEvents.start"/>
                                        <InputError :messages="postErrors ? postErrors.started_at : '' " />
                                    </div>
                                    <div class="flex flex-col justify-center items-left">
                                        <InputLabel value="Конец:" />
                                        <InputDefault :model-value="inputValue.end" v-on="inputEvents.end" />
                                        <InputError :messages="postErrors ? postErrors.finished_at : '' " />
                                    </div>
                                </div>
                            </template>
                        </VDatePicker>
                    </div>
                    <div class="w-full mb-6">
                        <h2 class="text-xl mb-3">
                            Итого:
                        </h2>
                        <p class="text-lg">
                            Дней: <span class="font-semibold">{{ currentDays ? currentDays : 1 }}</span>
                        </p>
                        <p class="text-lg">
                            Общая стоимость: <span class="font-semibold">{{ currentPrice ? priceFormat(currentPrice) : 0 }}₽</span>
                        </p>
                    </div>
                    <div v-if="postErrors">
                        <p class="text-lg text-red-600">{{ postErrors.message }}</p>
                    </div>
                    <div v-if="postResponse" >
                        <p class="text-lg text-green-600">{{ postResponse.message }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-action">
                <button
                    class="btn btn-primary"
                    type="submit"
                    :disabled="createBookingLoaded"
                >
                    {{ createBookingLoaded ? 'Подождите...' : 'Забронировать' }}
                </button>
                <button class="btn" @click.prevent="closeModal">Закрыть</button>
            </div>
        </form>
    </Modal>
</template>

<script>
import Modal from '@/Components/Modal.vue';
import { getBookedDates, createBooking } from "@/api/bookingData.js";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import InputDefault from "@/Components/InputDefault.vue";
import priceFormat from "@/helpers/priceFormat.js";

export default {
    name: "BookingModal",
    components: {
        InputLabel,
        InputError,
        InputDefault,
        Modal,
    },
    data() {
        return {
            datesRange: {
                start: this.formatDate(new Date()),
                end: this.formatDate(new Date()),
            },
            minDate: new Date(),
            bookedDates: [],
            datePickerColor: 'purple',
            masks: {
                modelValue: 'YYYY-MM-DD',
            },

            postErrors: null,
            postResponse: null,

            createBookingLoaded: false,
        };
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
    computed: {
        currentDays() {
            const startDay = new Date(this.datesRange.start);
            const endDay = new Date(this.datesRange.end);

            const differenceInMilliseconds = endDay - startDay;

            const differenceInDays = Math.ceil(differenceInMilliseconds / (1000 * 60 * 60 * 24));

            return differenceInDays + 1;
        },
        currentPrice() {
            return this.data.price * this.currentDays;
        },
    },
    methods: {
        priceFormat,
        closeModal() {
            this.$emit('update:showBookingModal', false);
        },
        getBooking() {
            getBookedDates(this.data.id)
                .then((response) => {
                    this.bookedDates = response.data.map(({ started_at, finished_at }) => [started_at, finished_at])
                })
        },
        postBooking() {
            this.createBookingLoaded = true;

            this.postErrors = null;
            this.postResponse = null;

            createBooking({
                room_id: this.data.id,
                started_at: this.datesRange.start,
                finished_at: this.datesRange.end,
            })
                .then((response) => {
                    this.postResponse = response.data;
                    this.createBookingLoaded = false;
                    this.getBooking();
                })
                .catch((error) => {
                    this.postErrors = error.response.data.errors;
                    this.createBookingLoaded = false;
                });

            getBookedDates();
        },
        formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        },
    },
    created() {
        this.getBooking();
    }
}
</script>

<style scoped>

</style>
