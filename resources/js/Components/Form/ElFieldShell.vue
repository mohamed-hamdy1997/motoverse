<template>
    <div class="w-full">
        <FloatLabel :variant="variant">
            <slot :id="id" :invalid="hasError" :described-by="hasError ? errorId : undefined"/>
            <label :for="id">
                {{ label }}
                <ElTextRequired v-if="required"/>
            </label>
        </FloatLabel>
        <ElTextError v-if="hasError" :id="errorId" :value="errorMessage"/>
        <ElTextHint v-else-if="hint" :value="hint"/>
    </div>
</template>

<script setup>
import {useId} from 'vue';
import FloatLabel from 'primevue/floatlabel';
import ElTextError from '@/Components/Text/ElTextError.vue';
import ElTextHint from '@/Components/Text/ElTextHint.vue';
import ElTextRequired from '@/Components/Text/ElTextRequired.vue';

/**
 * Label + error/hint wrapper shared by every floating El* field.
 */
defineProps({
    label: {type: String, required: true},
    required: {type: Boolean, default: false},
    variant: {type: String, default: 'on'},
    hasError: {type: Boolean, default: false},
    errorMessage: {type: String, default: null},
    hint: {type: String, default: null},
});

const id = useId();
const errorId = `${id}-error`;
</script>
