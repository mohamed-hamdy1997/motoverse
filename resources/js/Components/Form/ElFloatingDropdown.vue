<template>
    <ElFieldShell v-bind="shellProps" v-slot="{id, invalid, describedBy}">
        <Select
            v-model="form[name]"
            :label-id="id"
            :input-id="id"
            :options="options"
            :option-label="optionLabel"
            :option-value="optionValue"
            :option-group-label="optionGroupLabel"
            :option-group-children="optionGroupChildren"
            :invalid="invalid"
            :aria-describedby="describedBy"
            :disabled="disabled || form.processing"
            :show-clear="clearable"
            :filter="filter"
            class="w-full"
            v-bind="inputAttrs"
        >
            <template v-for="(_, slot) in $slots" #[slot]="slotProps">
                <slot :name="slot" v-bind="slotProps ?? {}"/>
            </template>
        </Select>
    </ElFieldShell>
</template>

<script setup>
import Select from 'primevue/select';
import ElFieldShell from '@/Components/Form/ElFieldShell.vue';
import {fieldProps, useFieldShell} from '@/Composables/useFieldShell.js';

defineOptions({inheritAttrs: false});

const props = defineProps({
    ...fieldProps,
    options: {type: Array, default: () => []},
    optionLabel: {type: String, default: 'name'},
    optionValue: {type: String, default: 'id'},
    optionGroupLabel: {type: String, default: undefined},
    optionGroupChildren: {type: String, default: undefined},
    clearable: {type: Boolean, default: false},
    filter: {type: Boolean, default: false},
});

const {shellProps, inputAttrs} = useFieldShell(props);
</script>
