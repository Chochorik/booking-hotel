<template>
    <Head title="Забронированные"/>

    <AuthenticatedLayout>
        <template #header>
            <Link
                class="font-semibold text-xl text-gray-800 leading-tight mr-2"
                :href="route('main')"
                as="button"
            >
                Забронированные номера
            </Link>
        </template>
    </AuthenticatedLayout>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

export default {
    name: "BookingPage",
    components: {
        Link,
        AuthenticatedLayout,
        Head,
    }
}
</script>

<style scoped>

</style>
