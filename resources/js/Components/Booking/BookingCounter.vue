<template>
    <div class="indicator">
        <div class="noti_count">{{ bookingCounter }}</div>
    </div>
</template>

<script>
export default {
    computed: {
        bookingCounter() {
            return this.$page.props.booking.booking_info.length;
        }
    }
}
</script>

<style scoped>
.indicator {
    position: absolute;
    width: 20px;
    height: 20px;
    top: 37%;
    right: 0;
    left: 100%;
    bottom: 0;
    background-color: rgba(77, 77, 77, 0.78);
    border: 1px solid rgba(77, 77, 77, 0.78);;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.noti_count {
    color: aliceblue;
    font-weight: 700;
}
</style>
