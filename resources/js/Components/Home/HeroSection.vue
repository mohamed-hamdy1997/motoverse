<template>
    <section id="top" class="relative isolate flex min-h-[100svh] flex-col overflow-hidden" aria-labelledby="hero-heading">
        <img
            src="/images/hero/hero.jpg"
            alt="A rider on an open desert road at golden hour"
            class="absolute inset-0 -z-20 h-full w-full animate-ken-burns object-cover object-[60%_center]"
            fetchpriority="high"
        >
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-ink-950/95 via-ink-950/60 to-ink-950/10" aria-hidden="true"/>
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950 via-transparent to-ink-950/50" aria-hidden="true"/>

        <div class="container-site flex flex-1 flex-col justify-end pb-10 pt-32 sm:pb-14">
            <p class="eyebrow">The Gulf's multi-brand motorcycle house</p>
            <h1 id="hero-heading" class="heading-display mt-6 text-[clamp(3.6rem,11vw,9.5rem)]">
                Four brands.<br>
                <span class="text-signal-500">One</span> ride culture.
            </h1>
            <p class="mt-6 max-w-xl text-lg leading-relaxed text-ink-200">
                From silent electric commuters to 208&nbsp;hp superbikes — discover, test ride, finance and service your next motorcycle
                with one team across {{ countryCount }} countries.
            </p>

            <div class="mt-9 flex flex-wrap gap-3">
                <a href="#test-ride" class="btn-primary !px-7 !py-3.5">
                    Book a test ride <i class="pi pi-arrow-right text-xs" aria-hidden="true"/>
                </a>
                <a href="#brands" class="btn-ghost !px-7 !py-3.5">Explore the brands</a>
            </div>

            <ul class="mt-14 grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-white/10 bg-white/10 backdrop-blur-md md:grid-cols-4" aria-label="Our brands">
                <li v-for="brand in brands" :key="brand.id">
                    <button
                        type="button"
                        class="group flex h-full w-full cursor-pointer flex-col items-start gap-1 bg-ink-950/70 p-4 text-left transition hover:bg-ink-950/40 sm:p-5"
                        :aria-label="`${brand.name}, ${brand.segment_label} — view line-up`"
                        @click="showLineup(brand.id)"
                    >
                        <span class="h-0.5 w-8 rounded-full transition-all duration-300 group-hover:w-14" :style="{background: brand.accent_color}" aria-hidden="true"/>
                        <span class="mt-2 font-display text-2xl font-bold uppercase tracking-wide text-white sm:text-3xl">{{ brand.name }}</span>
                        <span class="text-xs text-ink-300">{{ brand.segment_label }}</span>
                    </button>
                </li>
            </ul>
        </div>
    </section>
</template>

<script setup>
import {useHomeIntent} from '@/Composables/useHomeIntent.js';

defineProps({
    brands: {type: Array, required: true},
    countryCount: {type: Number, required: true},
});

const {showLineup} = useHomeIntent();
</script>
