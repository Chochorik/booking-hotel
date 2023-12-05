<script setup>
defineProps([
    'messages',
]);
</script>

<template>
    <div v-show="messages">
        <p v-for="message in messages" class="text-sm text-red-600">
            {{ message }}
        </p>
    </div>
</template>
