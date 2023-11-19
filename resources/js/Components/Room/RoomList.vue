<template>
    <ul class="m-full grid grid-cols-4 gap-6" v-if="showList">
        <RoomItem
            v-for="room in rooms"
            :key="room.id"
            :room="room"
        />
    </ul>
    <h3 v-else>
        В этом отеле пока еще нет номеров...
    </h3>
</template>

<script>
import RoomItem from "@/Components/Room/RoomItem.vue";

export default {
    name: "RoomList",
    components: {
        RoomItem,
    },
    props: {
        rooms: {
            type: Object,
            required: true,
        },
    },
    computed: {
        showList() {
            return this.rooms.length > 0;
        },
    }
}
</script>

<style scoped>

</style>
