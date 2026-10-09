<template>
    <small :id="id" class="mt-1.5 flex items-center gap-1 text-xs text-red-400" role="alert">
        <i class="pi pi-exclamation-circle text-[0.7rem]" aria-hidden="true"/>
        {{ value }}
    </small>
</template>

<script setup>
defineProps({
    value: {type: String, required: true},
    id: {type: String, default: null},
});
</script>
