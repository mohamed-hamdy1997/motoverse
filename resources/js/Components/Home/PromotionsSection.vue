<template>
    <section id="offers" class="py-20 sm:py-28" aria-labelledby="offers-heading">
        <div class="container-site">
            <SectionHeading id="offers-heading" eyebrow="Current offers" lead="Limited-time offers from across the group, updated by each brand team.">
                Offers worth<br>the ride.
            </SectionHeading>

            <div v-if="promotions.length" class="mt-14 grid gap-5 lg:grid-cols-2">
                <article
                    v-for="(promotion, index) in promotions"
                    :key="promotion.id"
                    v-reveal="index * 80"
                    class="group relative isolate flex min-h-64 flex-col justify-between overflow-hidden rounded-3xl border border-white/5 bg-ink-900 p-7 sm:p-9"
                    :style="{'--accent': promotion.brand.accent_color}"
                >
                    <img :src="promotion.brand.cover_image_url" alt="" loading="lazy" class="absolute inset-y-0 right-0 -z-20 h-full w-2/3 object-cover opacity-30 transition duration-700 group-hover:scale-105 group-hover:opacity-40" aria-hidden="true">
                    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-ink-900 via-ink-900/90 to-ink-900/30" aria-hidden="true"/>
                    <span class="absolute inset-y-0 left-0 w-1 bg-(--accent)" aria-hidden="true"/>

                    <div class="flex items-start justify-between gap-4">
                        <ElBrandTag :name="promotion.brand.name" :color="promotion.brand.accent_color"/>
                        <span class="flex items-center gap-1.5 text-xs text-ink-400">
                            <i class="pi pi-clock text-[0.7rem]" aria-hidden="true"/>
                            {{ endsInLabel(promotion.ends_at) }}
                        </span>
                    </div>

                    <div class="mt-8">
                        <p class="font-display text-4xl font-bold uppercase text-(--accent) sm:text-5xl">{{ promotion.highlight }}</p>
                        <h3 class="mt-2 text-xl font-semibold text-white">{{ promotion.title }}</h3>
                        <p class="mt-2 max-w-md text-sm leading-relaxed text-ink-300">{{ promotion.description }}</p>
                        <button type="button" class="mt-6 inline-flex cursor-pointer items-center gap-2 text-sm font-semibold text-white transition hover:gap-3" @click="requestEnquiry('sales')">
                            Claim this offer <i class="pi pi-arrow-right text-xs text-(--accent)" aria-hidden="true"/>
                        </button>
                    </div>
                </article>
            </div>

            <p v-else class="card-surface mt-14 p-10 text-center text-ink-400">New offers are on their way — check back soon.</p>
        </div>
    </section>
</template>

<script setup>
import SectionHeading from '@/Components/Home/SectionHeading.vue';
import ElBrandTag from '@/Components/Brand/ElBrandTag.vue';
import {daysUntil} from '@/Helpers/format.js';
import {useHomeIntent} from '@/Composables/useHomeIntent.js';

defineProps({
    promotions: {type: Array, required: true},
});

const {requestEnquiry} = useHomeIntent();

const endsInLabel = (date) => {
    const days = daysUntil(date);
    return days === 0 ? 'Ends today' : `Ends in ${days} day${days === 1 ? '' : 's'}`;
};
</script>
