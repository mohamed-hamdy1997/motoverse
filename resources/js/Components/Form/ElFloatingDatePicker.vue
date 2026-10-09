<template>
    <ElFieldShell v-bind="shellProps" v-slot="{id, invalid, describedBy}">
        <DatePicker
            v-model="dateValue"
            :input-id="id"
            :invalid="invalid"
            :aria-describedby="describedBy"
            :disabled="disabled || form.processing"
            :min-date="minDate"
            date-format="dd M yy"
            show-icon
            icon-display="input"
            class="w-full"
            fluid
            v-bind="inputAttrs"
        />
    </ElFieldShell>
</template>

<script setup>
import {computed} from 'vue';
import DatePicker from 'primevue/datepicker';
import ElFieldShell from '@/Components/Form/ElFieldShell.vue';
import {fieldProps, useFieldShell} from '@/Composables/useFieldShell.js';

defineOptions({inheritAttrs: false});

const props = defineProps({
    ...fieldProps,
    minDate: {type: Date, default: null},
});

const {shellProps, inputAttrs} = useFieldShell(props);

const toIsoDate = (date) => {
    const pad = (value) => String(value).padStart(2, '0');
    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`;
};

/**
 * The form stores a plain "YYYY-MM-DD" string so Laravel receives a timezone-safe date.
 */
const dateValue = computed({
    get: () => (props.form[props.name] ? new Date(`${props.form[props.name]}T00:00:00`) : null),
    set: (value) => {
        props.form[props.name] = value ? toIsoDate(value) : null;
    },
});
</script>
