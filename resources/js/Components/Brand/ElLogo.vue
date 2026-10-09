<template>
    <span class="inline-flex items-center gap-2.5">
        <svg viewBox="0 0 32 32" class="h-8 w-8 shrink-0" aria-hidden="true">
            <rect width="32" height="32" rx="8" class="fill-signal-500"/>
            <path d="M6 23 12 9h3l-3.6 8.4L17 9h3l-3.6 8.4L22 9h3l-6 14h-3l3.6-8.4L14 23h-3l3.6-8.4L9 23z" class="fill-ink-950"/>
        </svg>
        <span v-if="withText" class="font-display text-2xl font-bold uppercase tracking-[0.08em] text-white">
            Moto<span class="text-signal-500">verse</span>
        </span>
    </span>
</template>

<script setup>
defineProps({
    withText: {type: Boolean, default: true},
});
</script>
