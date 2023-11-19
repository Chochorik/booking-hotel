<template>
    <li class="py-1">
        {{ facility.title }}
    </li>
</template>

<script>
export default {
    name: "FacilityItem",
    props: {
        facility: {
            type: Object,
        }
    }
}
</script>

<style scoped>

</style>
