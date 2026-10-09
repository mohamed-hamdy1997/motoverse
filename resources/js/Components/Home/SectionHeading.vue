<template>
    <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between" v-reveal>
        <div class="max-w-2xl">
            <p class="eyebrow">{{ eyebrow }}</p>
            <h2 :id="id" class="heading-display mt-4 text-5xl sm:text-6xl lg:text-7xl">
                <slot/>
            </h2>
        </div>
        <p v-if="lead" class="max-w-md text-base leading-relaxed text-ink-300 md:text-right">{{ lead }}</p>
    </div>
</template>

<script setup>
defineProps({
    eyebrow: {type: String, required: true},
    lead: {type: String, default: null},
    id: {type: String, default: null},
});
</script>
