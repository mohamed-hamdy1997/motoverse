<template>
    <article
        class="group relative flex flex-col overflow-hidden rounded-3xl border border-white/5 bg-ink-900 transition duration-300 hover:-translate-y-1 hover:border-(--accent)/40 hover:shadow-2xl hover:shadow-black/40"
        :style="{'--accent': brand.accent_color}"
    >
        <div class="relative aspect-[4/3] overflow-hidden bg-ink-800">
            <img
                :src="motorcycle.image_url"
                :alt="`${brand.name} ${motorcycle.name}`"
                loading="lazy"
                class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-ink-900 via-transparent to-transparent" aria-hidden="true"/>
            <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                <ElBrandTag :name="brand.name" :color="brand.accent_color" solid class="backdrop-blur-md"/>
                <span v-if="motorcycle.is_electric" class="inline-flex items-center gap-1 rounded-full bg-ink-950/70 px-2.5 py-0.5 text-xs font-semibold text-teal-300 backdrop-blur-md">
                    <i class="pi pi-bolt text-[0.65rem]" aria-hidden="true"/> Electric
                </span>
            </div>
            <span v-if="motorcycle.is_featured" class="absolute right-4 top-4 rounded-full bg-ink-950/70 px-2.5 py-0.5 text-xs font-semibold text-signal-300 backdrop-blur-md">
                Featured
            </span>
        </div>

        <div class="flex flex-1 flex-col p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-(--accent)">{{ motorcycle.category_label }}</p>
            <h3 class="mt-1 font-display text-3xl font-bold uppercase text-white">{{ motorcycle.name }}</h3>
            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-ink-400">{{ motorcycle.description }}</p>

            <dl class="mt-5 grid grid-cols-3 divide-x divide-white/5 rounded-2xl bg-white/[0.03] py-3 text-center">
                <div v-for="spec in specs" :key="spec.label">
                    <dt class="text-[0.65rem] uppercase tracking-wider text-ink-500">{{ spec.label }}</dt>
                    <dd class="mt-0.5 font-display text-xl font-semibold text-ink-100">{{ spec.value }}</dd>
                </div>
            </dl>

            <div class="mt-6 flex items-end justify-between gap-3">
                <div>
                    <p class="text-xs text-ink-500">From</p>
                    <p class="font-display text-3xl font-bold text-white"><ElPrice :value="motorcycle.price"/></p>
                </div>
                <button type="button" class="cursor-pointer text-xs text-ink-400 underline-offset-4 hover:text-white hover:underline" @click="requestFinance(motorcycle.id)">
                    Calculate monthly
                </button>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-2">
                <button type="button" class="btn-primary !px-4 !py-2.5" @click="requestEnquiry('test_ride', motorcycle.id)">Test ride</button>
                <button type="button" class="btn-ghost !px-4 !py-2.5" @click="requestEnquiry('sales', motorcycle.id)">Enquire</button>
            </div>
        </div>
    </article>
</template>

<script setup>
import {computed} from 'vue';
import ElBrandTag from '@/Components/Brand/ElBrandTag.vue';
import ElPrice from '@/Components/Text/ElPrice.vue';
import {formatNumber} from '@/Helpers/format.js';
import {useHomeIntent} from '@/Composables/useHomeIntent.js';

const props = defineProps({
    motorcycle: {type: Object, required: true},
    brand: {type: Object, required: true},
});

const {requestEnquiry, requestFinance} = useHomeIntent();

const specs = computed(() => [
    {label: 'Engine', value: props.motorcycle.is_electric ? 'EV' : `${formatNumber(props.motorcycle.engine_cc)}cc`},
    {label: 'Power', value: `${props.motorcycle.power_hp} hp`},
    {label: 'Weight', value: `${props.motorcycle.weight_kg} kg`},
]);
</script>
