<template>
    <ElFieldShell v-bind="shellProps" v-slot="{id, invalid, describedBy}">
        <MultiSelect
            v-model="form[name]"
            :input-id="id"
            :options="options"
            :option-label="optionLabel"
            :option-value="optionValue"
            :invalid="invalid"
            :aria-describedby="describedBy"
            :disabled="disabled || form.processing"
            display="chip"
            class="w-full"
            v-bind="inputAttrs"
        />
    </ElFieldShell>
</template>

<script setup>
import MultiSelect from 'primevue/multiselect';
import ElFieldShell from '@/Components/Form/ElFieldShell.vue';
import {fieldProps, useFieldShell} from '@/Composables/useFieldShell.js';

defineOptions({inheritAttrs: false});

const props = defineProps({
    ...fieldProps,
    options: {type: Array, default: () => []},
    optionLabel: {type: String, default: 'name'},
    optionValue: {type: String, default: 'id'},
});

const {shellProps, inputAttrs} = useFieldShell(props);
</script>
