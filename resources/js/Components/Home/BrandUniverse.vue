<template>
    <section id="brands" class="py-20 sm:py-28" aria-labelledby="brands-heading">
        <div class="container-site">
            <SectionHeading
                id="brands-heading"
                eyebrow="The MotoVerse family"
                lead="Every brand keeps its own character and community — backed by one group for sales, service and support."
            >
                One house.<br>Four characters.
            </SectionHeading>

            <div class="mt-14 flex flex-col gap-3 lg:h-[36rem] lg:flex-row" v-reveal>
                <article
                    v-for="(brand, index) in brands"
                    :key="brand.id"
                    class="group relative isolate min-h-[28rem] overflow-hidden rounded-3xl border border-white/5 transition-[flex-grow] duration-700 ease-[cubic-bezier(.2,.8,.2,1)] lg:min-h-0"
                    :class="activeIndex === index ? 'lg:grow-[4.5]' : 'lg:grow'"
                    :style="{'--accent': brand.accent_color, flexBasis: 0}"
                    @mouseenter="activeIndex = index"
                >
                    <img
                        :src="brand.cover_image_url"
                        :alt="`${brand.name} — ${brand.segment_label}`"
                        loading="lazy"
                        class="absolute inset-0 -z-20 h-full w-full object-cover transition duration-700"
                        :class="activeIndex === index ? 'scale-100' : 'lg:scale-110 lg:grayscale-[60%]'"
                    >
                    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950 via-ink-950/55 to-ink-950/10" aria-hidden="true"/>
                    <span class="absolute inset-x-0 top-0 h-1 bg-(--accent)" aria-hidden="true"/>

                    <!-- Collapsed desktop label -->
                    <button
                        type="button"
                        class="absolute inset-0 hidden cursor-pointer flex-col items-center justify-end gap-4 pb-8 transition-opacity duration-300 lg:flex"
                        :class="activeIndex === index ? 'pointer-events-none opacity-0' : 'opacity-100'"
                        :aria-label="`Show ${brand.name}`"
                        :aria-expanded="activeIndex === index"
                        :tabindex="activeIndex === index ? -1 : 0"
                        @click="activeIndex = index"
                        @focus="activeIndex = index"
                    >
                        <span class="font-display text-4xl font-bold uppercase tracking-wider text-white [writing-mode:vertical-rl] rotate-180">{{ brand.name }}</span>
                        <span class="h-2 w-2 rounded-full bg-(--accent)" aria-hidden="true"/>
                    </button>

                    <!-- Expanded content -->
                    <div
                        class="flex h-full flex-col justify-end p-6 transition duration-500 sm:p-10"
                        :class="activeIndex === index ? 'opacity-100 lg:delay-200' : 'lg:pointer-events-none lg:translate-y-6 lg:opacity-0'"
                    >
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-(--accent)">
                            0{{ index + 1 }} · {{ brand.segment_label }}
                        </p>
                        <h3 class="heading-display mt-3 text-6xl sm:text-7xl">{{ brand.name }}</h3>
                        <p class="mt-2 text-lg font-medium text-ink-100">{{ brand.tagline }}</p>
                        <p class="mt-3 max-w-lg text-sm leading-relaxed text-ink-300">{{ brand.description }}</p>

                        <dl class="mt-6 flex flex-wrap gap-x-8 gap-y-3 text-sm">
                            <div>
                                <dt class="text-ink-400">Models</dt>
                                <dd class="font-display text-2xl font-bold text-white">{{ brand.motorcycles.length }}</dd>
                            </div>
                            <div v-if="brand.motorcycles.length">
                                <dt class="text-ink-400">Starting from</dt>
                                <dd class="font-display text-2xl font-bold text-white"><ElPrice :value="startingPrice(brand)"/></dd>
                            </div>
                        </dl>

                        <div class="mt-7">
                            <button
                                type="button"
                                class="inline-flex cursor-pointer items-center gap-2 rounded-full bg-(--accent) px-6 py-3 text-sm font-semibold text-ink-950 transition hover:brightness-110"
                                @click="showLineup(brand.id)"
                            >
                                Explore {{ brand.name }} line-up <i class="pi pi-arrow-right text-xs" aria-hidden="true"/>
                            </button>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
import {ref} from 'vue';
import SectionHeading from '@/Components/Home/SectionHeading.vue';
import ElPrice from '@/Components/Text/ElPrice.vue';
import {useHomeIntent} from '@/Composables/useHomeIntent.js';

defineProps({
    brands: {type: Array, required: true},
});

const {showLineup} = useHomeIntent();
const activeIndex = ref(0);

const startingPrice = (brand) => Math.min(...brand.motorcycles.map((motorcycle) => motorcycle.price));
</script>
