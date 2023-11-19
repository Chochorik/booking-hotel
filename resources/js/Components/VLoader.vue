<template>
    <div class="flex flex-col justify-center content-center loader-container">
        <div class="loader"></div>
        <p>
            Загрузка, подождите...
        </p>
    </div>
</template>

<script>
export default {
    name: "VLoader"
}
</script>

<style scoped>
.loader-container {
    margin: 0 auto;
}

.loader {
    margin: 0 auto;
    width: 48px;
    height: 48px;
    border: 5px solid;
    border-color: #a991f7 transparent;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
}

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
