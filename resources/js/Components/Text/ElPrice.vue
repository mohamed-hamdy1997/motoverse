<template>
    <span class="tabular-nums">{{ formatPrice(value) }}</span>
</template>

<script setup>
import {formatPrice} from '@/Helpers/format.js';

defineProps({
    value: {type: [Number, String], required: true},
});
</script>
