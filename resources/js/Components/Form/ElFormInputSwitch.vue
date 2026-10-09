<template>
    <div>
        <label :for="id" class="flex cursor-pointer items-center gap-3 select-none">
            <ToggleSwitch v-model="form[name]" :input-id="id" :disabled="form.processing" :invalid="hasError"/>
            <span class="text-sm text-ink-200">{{ label }}</span>
        </label>
        <ElTextError v-if="hasError" :value="errorMessage"/>
    </div>
</template>

<script setup>
import {useId} from 'vue';
import ToggleSwitch from 'primevue/toggleswitch';
import ElTextError from '@/Components/Text/ElTextError.vue';
import {fieldProps, useFieldError} from '@/Composables/useFieldError.js';

const props = defineProps(fieldProps);

const id = useId();
const {errorMessage, hasError} = useFieldError(props);
</script>
