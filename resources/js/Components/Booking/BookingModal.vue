<template>
    <div class="absolute z-40" v-show="showBookingModal">
        <dialog id="my_modal_4" class="modal opacity-100">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg">Hello!</h3>
                <p class="py-4">Click the button below to close</p>
                <div class="modal-action">
                    <button class="btn" @click.prevent="closeModal">Закрыть</button>
                </div>
            </div>
        </dialog>
        <div class="fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-50"></div>
    </div>
</template>

<script>
export default {
    name: "BookingModal",
    props: {
        showBookingModal: {
            type: Boolean,
            default: false,
        }
    },
    methods: {
        closeModal() {
            this.$emit('update:showBookingModal', false);
        }
    }
}
</script>

<style scoped>
.modal {
    pointer-events: all;
}
</style>
