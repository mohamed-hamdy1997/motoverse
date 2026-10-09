<template>
    <section class="mx-auto flex max-w-7xl flex-col gap-6">
        <Head :title="title"/>
        <header class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="font-display text-3xl font-bold uppercase tracking-wide text-white sm:text-4xl">{{ title }}</h1>
                <p v-if="description" class="mt-1 max-w-2xl text-sm text-ink-400">{{ description }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <slot name="actions"/>
            </div>
        </header>

        <div v-if="$slots.filters" class="flex flex-wrap items-center gap-3">
            <slot name="filters"/>
        </div>

        <div :class="{'card-surface p-4 sm:p-6': padded}">
            <slot/>
        </div>
    </section>
</template>

<script setup>
import {Head} from '@inertiajs/vue3';

defineProps({
    title: {type: String, required: true},
    description: {type: String, default: null},
    padded: {type: Boolean, default: true},
});
</script>
