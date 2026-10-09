<template>
    <Button
        type="submit"
        :label="text"
        :icon="icon"
        :loading="form?.processing || processing"
        :disabled="disabled || form?.processing || processing"
        :aria-busy="form?.processing || processing"
        v-bind="$attrs"
    />
</template>

<script setup>
import Button from 'primevue/button';

defineProps({
    text: {type: String, default: 'Save'},
    icon: {type: String, default: 'pi pi-check'},
    form: {type: Object, default: null},
    processing: {type: Boolean, default: false},
    disabled: {type: Boolean, default: false},
});
</script>
