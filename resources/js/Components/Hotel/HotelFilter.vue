<template>
    <aside class="card card-normal bg-base-100 p-5 filter max-w-md">
        <form class="filter__form form">
            <h2 class="text-lg mb-3">
                Фильтр поиска
            </h2>
            <fieldset class="form__block flex flex-col">
                <legend class="form__legend">Стоимость комнат:</legend>
                <label class="form__label form__label--price mb-2">
                    <span class="form__value">От</span>
                    <input
                        type="text"
                        placeholder="0"
                        class="input input-bordered input-primary w-full max-w-xs"
                        name="min-price"
                        v-model.number="currentPriceFrom"
                    />
                </label>
                <label class="form__label form__label--price mb-2">
                    <span class="form__value">До</span>
                    <input
                        type="text"
                        placeholder="10000"
                        class="input input-bordered input-primary w-full max-w-xs"
                        name="max-price"
                        v-model.number="currentPriceTo"
                    />
                </label>
            </fieldset>

            <fieldset class="form__block mb-2">
                <legend class="form__legend">Рейтинг отеля:</legend>
                <div class="rating rating-md">
                    <input v-model.number="currentRating" type="radio" :value="1" name="rating" class="mask mask-star-2 bg-orange-400" />
                    <input v-model.number="currentRating" type="radio" :value="2" name="rating" class="mask mask-star-2 bg-orange-400" />
                    <input v-model.number="currentRating" type="radio" :value="3" name="rating" class="mask mask-star-2 bg-orange-400" />
                    <input v-model.number="currentRating" type="radio" :value="4" name="rating" class="mask mask-star-2 bg-orange-400" />
                    <input v-model.number="currentRating" type="radio" :value="5" name="rating" class="mask mask-star-2 bg-orange-400" />
                </div>
            </fieldset>

            <fieldset class="form__block facility-fieldset">
                <legend class="form__legend">Удобства:</legend>
                <label
                    v-for="facility in facilities.slice(0, visibleFacilities)"
                    class="form__label form__label--select facility-checkbox cursor-pointer label"
                >
                    <input
                        class="checkbox checkbox-xs"
                        :key="facility.id"
                        type="checkbox"
                        name="facility"
                        :value="facility.id"
                        v-model="currentFacilities"
                    >
                    {{ facility.title }}
                </label>
                <button
                    class="filter__show-all link link-primary"
                    type="button"
                    @click="toggleShowAllFacilities"
                >
                    {{ showAllFacilities ? 'Скрыть' : 'Показать' }} все
                </button>
            </fieldset>

            <div class="flex flex-col items-start action-buttons">
                <button
                    class="btn btn-active btn-primary mb-3"
                    type="submit"
                    @click.prevent="submit"
                >
                    Применить
                </button>
                <button
                    v-show="showResetBtn"
                    class="btn btn-outline btn-secondary"
                    type="button"
                    @click.prevent="resetFilter"
                >
                    Сбросить
                </button>
            </div>
        </form>
    </aside>
</template>

<script>
import { getAllFacilities } from "@/api/facilitiesData.js";

export default {
    name: "HotelFilter",
    data() {
        return {
            currentPriceFrom: 0,
            currentPriceTo: 0,
            currentRating: 0,
            currentFacilities: [],

            facilities: [],

            visibleFacilities: 3,

            showAllFacilities: false,
        }
    },
    computed: {
        showResetBtn() {
            if (this.currentPriceFrom > 0
                || this.currentPriceTo > 0
                || this.currentRating > 0
                || this.currentFacilities.length > 0) {
                return true;
            }

            return false;
        },
    },
    emits: [
        'update:price-from',
        'update:price-to',
        'update:rating',
        'update:facilities',
    ],
    methods: {
        getFacilitiesList() {
            getAllFacilities()
                .then((response) => {
                this.facilities = response.data;
            });
        },
        toggleShowAllFacilities() {
            this.showAllFacilities = !this.showAllFacilities;

            if (this.showAllFacilities) {
                this.visibleFacilities = this.facilities.length;
            } else {
                this.visibleFacilities = 3;
            }
        },
        submit() {
            this.$emit('update:price-from', this.currentPriceFrom);
            this.$emit('update:price-to', this.currentPriceTo);
            this.$emit('update:rating', this.currentRating);
            this.$emit('update:facilities', this.currentFacilities);
        },
        resetFilter() {
            this.currentPriceFrom = 0;
            this.currentPriceTo = 0;
            this.currentRating = 0;
            this.currentFacilities = [];

            this.$emit('update:price-from', 0);
            this.$emit('update:price-to', 0);
            this.$emit('update:rating', 0);
            this.$emit('update:facilities', []);
        },
    },
    created() {
        this.getFacilitiesList();
    }
}
</script>

<style scoped>
.filter {
    margin-right: 30px;
    height: fit-content;
}

.form__label {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form__value {
    margin-right: 20px;
}

.checkbox {
    margin-right: 10px;
}

.facility-checkbox {
    justify-content: flex-start;
    align-items: center;
}

.facility-fieldset {
    margin-bottom: 20px;
}
</style>
