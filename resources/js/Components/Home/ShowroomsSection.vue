<template>
    <section id="showrooms" class="py-20 sm:py-28" aria-labelledby="showrooms-heading">
        <div class="container-site">
            <SectionHeading
                id="showrooms-heading"
                eyebrow="Showrooms & service centres"
                :lead="`${showrooms.length} locations across ${countries.length} countries — every one carries all four brands.`"
            >
                Find us across<br>the Gulf.
            </SectionHeading>

            <div class="mt-12 flex flex-wrap gap-2" role="tablist" aria-label="Country">
                <button
                    v-for="country in countries"
                    :id="`tab-${slug(country)}`"
                    :key="country"
                    type="button"
                    role="tab"
                    class="cursor-pointer rounded-full border px-5 py-2 text-sm font-medium transition"
                    :class="activeCountry === country ? 'border-signal-500 bg-signal-500 text-ink-950' : 'border-white/10 text-ink-300 hover:border-white/30 hover:text-white'"
                    :aria-selected="activeCountry === country"
                    :aria-controls="`panel-${slug(country)}`"
                    @click="activeCountry = country"
                >
                    {{ country }}
                    <span class="ml-1 opacity-60">{{ countByCountry[country] }}</span>
                </button>
            </div>

            <div
                :id="`panel-${slug(activeCountry)}`"
                role="tabpanel"
                :aria-labelledby="`tab-${slug(activeCountry)}`"
                class="mt-8 grid gap-4 md:grid-cols-2 lg:grid-cols-3"
            >
                <article v-for="showroom in visibleShowrooms" :key="showroom.id" class="card-surface flex flex-col p-7 transition hover:border-white/15">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-signal-400">{{ showroom.city }}</p>
                            <h3 class="mt-1 text-xl font-semibold text-white">{{ showroom.name }}</h3>
                        </div>
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-white/5 text-ink-300"><i class="pi pi-map-marker" aria-hidden="true"/></span>
                    </div>

                    <ul class="mt-5 flex-1 space-y-2.5 text-sm text-ink-300">
                        <li class="flex gap-3"><i class="pi pi-building mt-0.5 text-ink-500" aria-hidden="true"/>{{ showroom.address }}</li>
                        <li class="flex gap-3"><i class="pi pi-clock mt-0.5 text-ink-500" aria-hidden="true"/>{{ showroom.opening_hours }}</li>
                        <li class="flex gap-3">
                            <i class="pi pi-phone mt-0.5 text-ink-500" aria-hidden="true"/>
                            <a :href="`tel:${showroom.phone.replace(/\s/g, '')}`" class="hover:text-white">{{ showroom.phone }}</a>
                        </li>
                    </ul>

                    <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-white/5 pt-5">
                        <div class="flex gap-2">
                            <span class="rounded-full bg-white/5 px-2.5 py-1 text-xs text-ink-300">Showroom</span>
                            <span v-if="showroom.has_service_center" class="rounded-full bg-signal-500/10 px-2.5 py-1 text-xs text-signal-300">Service centre</span>
                        </div>
                        <a
                            :href="`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(`${showroom.address}, ${showroom.city}, ${showroom.country}`)}`"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 text-sm font-semibold text-white hover:text-signal-300"
                        >
                            Directions <i class="pi pi-external-link text-xs" aria-hidden="true"/>
                            <span class="sr-only">(opens Google Maps in a new tab)</span>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
import {computed, ref} from 'vue';
import SectionHeading from '@/Components/Home/SectionHeading.vue';

const props = defineProps({
    showrooms: {type: Array, required: true},
});

const countByCountry = computed(() => props.showrooms.reduce((counts, showroom) => {
    counts[showroom.country] = (counts[showroom.country] ?? 0) + 1;
    return counts;
}, {}));

const countries = computed(() => Object.keys(countByCountry.value).sort((a, b) => countByCountry.value[b] - countByCountry.value[a]));
const activeCountry = ref(countries.value[0] ?? '');
const visibleShowrooms = computed(() => props.showrooms.filter((showroom) => showroom.country === activeCountry.value));

const slug = (value) => value.toLowerCase().replace(/[^a-z0-9]+/g, '-');
</script>
