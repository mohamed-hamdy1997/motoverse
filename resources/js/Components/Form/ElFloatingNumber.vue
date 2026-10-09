<template>
    <ElFieldShell v-bind="shellProps" v-slot="{id, invalid, describedBy}">
        <InputNumber
            v-model="form[name]"
            :input-id="id"
            :invalid="invalid"
            :aria-describedby="describedBy"
            :disabled="disabled || form.processing"
            :min="min"
            :max="max"
            :suffix="suffix"
            :prefix="prefix"
            :use-grouping="useGrouping"
            class="w-full"
            fluid
            v-bind="inputAttrs"
        />
    </ElFieldShell>
</template>

<script setup>
import InputNumber from 'primevue/inputnumber';
import ElFieldShell from '@/Components/Form/ElFieldShell.vue';
import {fieldProps, useFieldShell} from '@/Composables/useFieldShell.js';

defineOptions({inheritAttrs: false});

const props = defineProps({
    ...fieldProps,
    min: {type: Number, default: 0},
    max: {type: Number, default: null},
    suffix: {type: String, default: null},
    prefix: {type: String, default: null},
    useGrouping: {type: Boolean, default: true},
});

const {shellProps, inputAttrs} = useFieldShell(props);
</script>
