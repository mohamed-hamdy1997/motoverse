<template>
    <div>
        <label :for="id" class="mb-1.5 block text-xs font-medium text-ink-400">
            {{ label }}
            <ElTextRequired v-if="required"/>
        </label>
        <div class="flex items-center gap-3">
            <ColorPicker v-model="pickerValue" :input-id="`${id}-picker`" :disabled="form.processing"/>
            <InputText :id="id" v-model="form[name]" :invalid="hasError" class="w-32 font-mono uppercase" maxlength="7"/>
            <span class="h-9 flex-1 rounded-lg border border-white/10" :style="{background: form[name]}" aria-hidden="true"/>
        </div>
        <ElTextError v-if="hasError" :value="errorMessage"/>
    </div>
</template>

<script setup>
import {computed, useId} from 'vue';
import ColorPicker from 'primevue/colorpicker';
import InputText from 'primevue/inputtext';
import ElTextError from '@/Components/Text/ElTextError.vue';
import ElTextRequired from '@/Components/Text/ElTextRequired.vue';
import {fieldProps, useFieldError} from '@/Composables/useFieldError.js';

const props = defineProps(fieldProps);

const id = useId();
const {errorMessage, hasError} = useFieldError(props);

/**
 * PrimeVue's ColorPicker works with hex without "#"; the form keeps the full "#rrggbb".
 */
const pickerValue = computed({
    get: () => (props.form[props.name] ?? '').replace('#', ''),
    set: (value) => {
        props.form[props.name] = `#${value}`;
    },
});
</script>
