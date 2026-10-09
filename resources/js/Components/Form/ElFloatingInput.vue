<template>
    <ElFieldShell v-bind="shellProps" v-slot="{id, invalid, describedBy}">
        <InputText
            :id="id"
            v-model="form[name]"
            :type="type"
            :invalid="invalid"
            :aria-describedby="describedBy"
            :aria-required="required"
            :disabled="disabled || form.processing"
            class="w-full"
            v-bind="inputAttrs"
        />
    </ElFieldShell>
</template>

<script setup>
import InputText from 'primevue/inputtext';
import ElFieldShell from '@/Components/Form/ElFieldShell.vue';
import {fieldProps, useFieldShell} from '@/Composables/useFieldShell.js';

defineOptions({inheritAttrs: false});

const props = defineProps({
    ...fieldProps,
    type: {type: String, default: 'text'},
});

const {shellProps, inputAttrs} = useFieldShell(props);
</script>
