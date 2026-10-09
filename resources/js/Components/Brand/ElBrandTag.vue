<template>
    <span
        class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-xs font-semibold"
        :style="{color: color, borderColor: `${color}55`, background: solid ? 'rgb(10 11 13 / 0.75)' : `${color}14`}"
    >
        <span class="h-1.5 w-1.5 rounded-full" :style="{background: color}" aria-hidden="true"/>
        {{ name }}
    </span>
</template>

<script setup>
defineProps({
    name: {type: String, required: true},
    color: {type: String, default: '#ff6b2c'},
    /** Dark backdrop for legibility on top of photos */
    solid: {type: Boolean, default: false},
});
</script>
