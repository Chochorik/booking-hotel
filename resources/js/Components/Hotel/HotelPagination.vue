<template>
    <div class="join">
        <button
            class="join-item btn disabled:opacity-75"
            @click.prevent="prevPage"
            :disabled="page === 1"
        >
            «
        </button>
        <div class="join-item btn">Страница {{ page }}</div>
        <button
            class="join-item btn disabled:opacity-75"
            @click.prevent="nextPage"
            :disabled="page === pages"
        >
            »
        </button>
    </div>
</template>

<script>
export default {
    name: "HotelPagination",
    props: {
        page: {
            type: Number,
        },
        count: {
            type: Number,
        },
        perPage: {
            type: Number,
        }
    },
    computed: {
        pages() {
            return Math.ceil(this.count / this.perPage)
        },
    },
    methods: {
        prevPage() {
            if (this.page > 1) {
                this.$emit('update:page', this.page - 1);
            }
        },
        nextPage() {
            if (this.page < this.pages) {
                this.$emit('update:page', this.page + 1);
            }
        }
    }
}
</script>

<style scoped>

</style>
