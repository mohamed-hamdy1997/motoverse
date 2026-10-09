<template>
    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold" :class="tone">
        <span class="h-1.5 w-1.5 rounded-full bg-current" aria-hidden="true"/>
        {{ label }}
    </span>
</template>

<script setup>
import {computed} from 'vue';

const props = defineProps({
    label: {type: String, required: true},
    severity: {type: String, default: 'neutral'},
});

const tones = {
    success: 'bg-emerald-500/10 text-emerald-400',
    warning: 'bg-amber-500/10 text-amber-400',
    info: 'bg-sky-500/10 text-sky-400',
    danger: 'bg-red-500/10 text-red-400',
    neutral: 'bg-white/5 text-ink-300',
};

const tone = computed(() => tones[props.severity] ?? tones.neutral);
</script>
