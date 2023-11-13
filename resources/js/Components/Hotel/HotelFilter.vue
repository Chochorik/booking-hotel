<template>
    <aside class="card card-normal bg-base-100 p-5 filter max-w-md">
        <form class="filter__form form">
            <h2 class="text-lg mb-3">
                Фильтр поиска
            </h2>
            <fieldset class="form__block flex flex-col">
                <legend class="form__legend">Цена:</legend>
                <label class="form__label form__label--price mb-2">
                    <span class="form__value">От</span>
                    <input type="text" placeholder="0" class="input input-bordered input-primary w-full max-w-xs" name="min-price" />
                </label>
                <label class="form__label form__label--price mb-2">
                    <span class="form__value">До</span>
                    <input type="text" placeholder="10000" class="input input-bordered input-primary w-full max-w-xs" name="max-price"/>
                </label>
            </fieldset>

            <fieldset class="form__block mb-2">
                <legend class="form__legend">Категория:</legend>
                <div class="rating rating-md">
                    <input v-model="rating" type="radio" name="rating" class="mask mask-star-2 bg-orange-400" />
                    <input v-model="rating" type="radio" name="rating" class="mask mask-star-2 bg-orange-400" />
                    <input v-model="rating" type="radio" name="rating" class="mask mask-star-2 bg-orange-400" />
                    <input v-model="rating" type="radio" name="rating" class="mask mask-star-2 bg-orange-400" />
                    <input v-model="rating" type="radio" name="rating" class="mask mask-star-2 bg-orange-400" />
                </div>
            </fieldset>

            <fieldset class="form__block">
                <legend class="form__legend">Удобства:</legend>
                <label class="form__label form__label--select">
                    <input type="checkbox" name="facility">
                </label>
            </fieldset>

            <button class="filter__submit button button--primery" type="submit">
                Применить
            </button>
            <button
                class="filter__reset button button--second"
                type="button"
            >
                Сбросить
            </button>
        </form>
    </aside>
</template>

<script>
export default {
    name: "HotelFilter",
    data() {
        return {
            rating: 0,
        }
    }
}
</script>

<style scoped>
.filter {
    margin-right: 30px;
    min-height: fit-content;
}

.form__label {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form__value {
    margin-right: 20px;
}
</style>
