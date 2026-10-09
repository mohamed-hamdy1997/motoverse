<template>
    <ElFieldShell v-bind="shellProps" v-slot="{id, invalid, describedBy}">
        <Textarea
            :id="id"
            v-model="form[name]"
            :rows="rows"
            :invalid="invalid"
            :aria-describedby="describedBy"
            :disabled="disabled || form.processing"
            class="w-full"
            auto-resize
            v-bind="inputAttrs"
        />
    </ElFieldShell>
</template>

<script setup>
import Textarea from 'primevue/textarea';
import ElFieldShell from '@/Components/Form/ElFieldShell.vue';
import {fieldProps, useFieldShell} from '@/Composables/useFieldShell.js';

defineOptions({inheritAttrs: false});

const props = defineProps({
    ...fieldProps,
    rows: {type: Number, default: 3},
});

const {shellProps, inputAttrs} = useFieldShell(props);
</script>
