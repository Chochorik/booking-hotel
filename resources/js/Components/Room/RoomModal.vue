<template>
    <Modal :show="showRoomModal">
        <div class="p-6 flex flex-col justify-between w-full">
            <h2 class="font-bold text-3xl mb-2">
                Информация о брони
            </h2>
            <div class="grid grid-cols-2 gap-4 w-full mb-5">
                <div class="relative">
                    <VLoader
                        v-show="showLoader"
                        class="absolute loader-container"
                    />
                    <img class="max-w-[305px] max-h-[305px]" :src="roomImage" :alt="roomTitle">
                </div>
                <div>
                    <RoomModalTable
                        :booking="booking"
                    />
                </div>
            </div>
            <div class="w-full">
                <p v-if="bookingStatus === 'pending'" class="text-lg text-center">
                    Необходимо подтвердить бронирование! Пожалуйста, проверьте Вашу почту.
                </p>
                <p v-if="deletingResponse.message" class="text-lg text-center text-green-600">
                    {{ deletingResponse.message }}
                </p>
            </div>
            <div class="modal-action">
                <button
                    v-if="bookingStatus === 'confirmed'"
                    class="btn btn-outline btn-error"
                    @click.prevent="cancelBooking"
                >
                    Отменить бронирование
                </button>
                <button
                    class="btn btn-error"
                    v-if="bookingStatus === 'canceled' || bookingStatus === 'expired'"
                    @click.prevent="destroyBooking"
                >
                    Удалить
                </button>

                <button class="btn" @click.prevent="closeModal">Закрыть</button>
            </div>
        </div>
    </Modal>
</template>

<script>
import Modal from '@/Components/Modal.vue';
import VLoader from "@/Components/VLoader.vue";
import RoomModalTable from "@/Components/Room/RoomModalTable.vue";
import { NO_PHOTO_URL } from "@/dataConfig.js";
import { cancelBooking, deleteBooking } from "@/api/bookingData.js";

export default {
    name: "RoomModal",
    data() {
        return {
            deletingResponse: '',
            deletingErrors: null,

            showDeletingLoader: false,

            showLoader: true,
        }
    },
    components: {
        Modal,
        VLoader,
        RoomModalTable,
    },
    props: {
        showRoomModal: {
            type: Boolean,
            default: false,
        },
        booking: {
            type: Object,
            required: true,
        },
    },
    emits: [
        'update:showRoomModal',
        'closeModal',
        'booking-cancelled',
    ],
    computed: {
        roomImage() {
            return this.booking.room.poster_url ? '/storage/' + this.booking.room.poster_url : NO_PHOTO_URL;
        },
        roomTitle() {
            return this.booking.room.title;
        },
        bookingStatus() {
            return this.booking.status;
        },
    },
    methods: {
        closeModal() {
            this.$emit('update:showRoomModal', false);
        },
        cancelBooking() {
            this.showDeletingLoader = true;

            cancelBooking(this.booking.id)
                .then((response) => {
                    this.deletingResponse = response.data;
                    this.showDeletingLoader = false;
                    this.$emit('booking-cancelled');
                })
                .catch((response) => {
                    this.deletingErrors = response.data;
                    this.showDeletingLoader = false;
                });
        },
        destroyBooking() {
            deleteBooking(this.booking.id)
                .then((response) => {
                    this.deletingResponse = response.data;
                    this.showDeletingLoader = false;
                    this.$emit('booking-cancelled');
                })
                .catch((response) => {
                    this.deletingErrors = response.data;
                    this.showDeletingLoader = false;
                });
        },
    },
    created() {
        const img = new Image();
        img.src = this.roomImage;
        img.onload = () => {
            this.showLoader = false;
        };
    }
}
</script>

<style scoped>

</style>
