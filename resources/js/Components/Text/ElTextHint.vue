<template>
    <small class="mt-1.5 block text-xs text-ink-400">{{ value }}</small>
</template>

<script setup>
defineProps({
    value: {type: String, required: true},
});
</script>
