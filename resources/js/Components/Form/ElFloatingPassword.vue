<template>
    <ElFieldShell v-bind="shellProps" v-slot="{id, invalid, describedBy}">
        <Password
            v-model="form[name]"
            :input-id="id"
            :invalid="invalid"
            :aria-describedby="describedBy"
            :disabled="disabled || form.processing"
            :feedback="false"
            toggle-mask
            class="w-full"
            fluid
            v-bind="inputAttrs"
        />
    </ElFieldShell>
</template>

<script setup>
import Password from 'primevue/password';
import ElFieldShell from '@/Components/Form/ElFieldShell.vue';
import {fieldProps, useFieldShell} from '@/Composables/useFieldShell.js';

defineOptions({inheritAttrs: false});

const props = defineProps(fieldProps);

const {shellProps, inputAttrs} = useFieldShell(props);
</script>
