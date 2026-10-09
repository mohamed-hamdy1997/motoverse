<template>
    <section id="models" class="bg-ink-900/40 py-20 sm:py-28" aria-labelledby="models-heading">
        <div class="container-site">
            <SectionHeading
                id="models-heading"
                eyebrow="The line-up"
                lead="Compare specs, check prices and book a test ride at the showroom nearest to you."
            >
                Find your<br>machine.
            </SectionHeading>

            <div class="mt-12 flex flex-wrap items-center justify-between gap-4" v-reveal>
                <div class="-mx-4 flex gap-2 overflow-x-auto px-4 pb-1 sm:mx-0 sm:flex-wrap sm:px-0" role="group" aria-label="Filter by brand">
                    <button
                        v-for="filter in filters"
                        :key="filter.id ?? 'all'"
                        type="button"
                        class="flex shrink-0 cursor-pointer items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium transition"
                        :class="isSelected(filter.id) ? 'border-white bg-white text-ink-950' : 'border-white/10 text-ink-300 hover:border-white/30 hover:text-white'"
                        :aria-pressed="isSelected(filter.id)"
                        @click="state.lineupBrandId = filter.id"
                    >
                        <span v-if="filter.color" class="h-2 w-2 rounded-full" :style="{background: filter.color}" aria-hidden="true"/>
                        {{ filter.label }}
                        <span class="text-xs opacity-60">{{ filter.count }}</span>
                    </button>
                </div>

                <label class="flex items-center gap-2 text-sm text-ink-300">
                    <ToggleSwitch v-model="electricOnly" input-id="electric-only"/>
                    <span>Electric only</span>
                </label>
            </div>

            <p class="sr-only" aria-live="polite">{{ visibleModels.length }} models shown</p>

            <TransitionGroup
                tag="div"
                class="relative mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                enter-from-class="opacity-0 translate-y-4"
                enter-active-class="transition duration-500"
                leave-active-class="transition duration-200 absolute opacity-0"
                move-class="transition duration-500"
            >
                <ModelCard v-for="item in visibleModels" :key="item.motorcycle.id" :motorcycle="item.motorcycle" :brand="item.brand"/>
            </TransitionGroup>

            <div v-if="!visibleModels.length" class="card-surface mt-10 p-10 text-center text-ink-400">
                No models match these filters.
                <button type="button" class="ml-1 cursor-pointer text-signal-400 hover:underline" @click="resetFilters">Reset filters</button>
            </div>
        </div>
    </section>
</template>

<script setup>
import {computed, ref} from 'vue';
import ToggleSwitch from 'primevue/toggleswitch';
import SectionHeading from '@/Components/Home/SectionHeading.vue';
import ModelCard from '@/Components/Home/ModelCard.vue';
import {useHomeIntent} from '@/Composables/useHomeIntent.js';

const props = defineProps({
    brands: {type: Array, required: true},
});

const {state} = useHomeIntent();
const electricOnly = ref(false);

const allModels = computed(() => props.brands.flatMap((brand) => brand.motorcycles.map((motorcycle) => ({motorcycle, brand}))));

const filters = computed(() => [
    {id: null, label: 'All brands', count: allModels.value.length},
    ...props.brands.map((brand) => ({id: brand.id, label: brand.name, color: brand.accent_color, count: brand.motorcycles.length})),
]);

const visibleModels = computed(() => allModels.value.filter(({motorcycle, brand}) =>
    (state.lineupBrandId === null || brand.id === state.lineupBrandId)
    && (!electricOnly.value || motorcycle.is_electric)));

const isSelected = (brandId) => state.lineupBrandId === brandId;

const resetFilters = () => {
    state.lineupBrandId = null;
    electricOnly.value = false;
};
</script>
