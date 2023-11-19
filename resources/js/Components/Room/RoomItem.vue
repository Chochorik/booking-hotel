<template>
    <div class="card card-compact max-w-full bg-base-100 shadow-xl">
        <figure>
            <img class="room__picture" :src="roomImage" :alt="room.title" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">{{ room.title }}</h2>
            <p class="text-sm">
                {{ room.description }}
            </p>
            <p class="text-accent-content">
                Тип: {{ room.type }}
            </p>
            <b class="text-accent-content">
                Цена: {{ priceFormat(room.price) }} ₽
            </b>
            <div class="card-actions justify-end">
                <Link :href="route('room.get.current', { 'id': room.id })" as="button" class="btn btn-primary">Подробнее...</Link>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import truncateDescription from "@/helpers/truncateDescription.js";
import priceFormat from "@/helpers/priceFormat.js";
import { NO_PHOTO_URL } from "@/dataConfig.js";

export default {
    name: "RoomItem",
    components: {
        Link,
    },
    props: {
        room: {
            type: Object,
            required: true,
        }
    },
    computed: {
        roomImage() {
            return this.room.poster_url ? '/storage/' + this.room.poster_url : NO_PHOTO_URL;
        },
        truncatedDescr() {
            return truncateDescription(this.room.description.trim(), 100);
        },
    },
    methods: {
        priceFormat,
    }
}
</script>

<style scoped>
.room__picture {
    width: 100%;
    height: 210px;
}
</style>
