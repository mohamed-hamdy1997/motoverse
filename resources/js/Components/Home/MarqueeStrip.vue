<template>
    <div class="relative overflow-hidden border-y border-white/5 bg-ink-900 py-5" aria-hidden="true">
        <div class="flex w-max animate-marquee gap-10 whitespace-nowrap">
            <template v-for="copy in 2" :key="copy">
                <span v-for="word in words" :key="`${copy}-${word}`" class="flex items-center gap-10 font-display text-2xl font-semibold uppercase tracking-wider text-ink-500">
                    {{ word }}
                    <span class="h-1.5 w-1.5 rotate-45 bg-signal-500"/>
                </span>
            </template>
        </div>
    </div>
</template>

<script setup>
const words = ['Sales', 'Test rides', 'Financing', 'Service & maintenance', 'Parts & accessories', 'Warranty', 'Customer care', 'Rider academy'];
</script>
