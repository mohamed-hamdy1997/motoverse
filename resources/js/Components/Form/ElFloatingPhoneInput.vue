<template>
    <ElFieldShell v-bind="shellProps" v-slot="{ invalid }">
        <div class="phone-field w-full" :class="{ 'phone-field-invalid': invalid }">
            <IntlTelInput
                v-model="form[name]"
                initial-country="eg"
                :separate-dial-code="true"
                :load-utils="() => import('intl-tel-input/utils')"
                placeholder-number-policy="AGGRESSIVE"
                placeholder-number-type="MOBILE"
            />
        </div>
    </ElFieldShell>
</template>

<script setup>
import IntlTelInput from '@intl-tel-input/vue';
import 'intl-tel-input/styles';
import ElFieldShell from '@/Components/Form/ElFieldShell.vue';
import {fieldProps, useFieldShell} from '@/Composables/useFieldShell.js';

defineOptions({inheritAttrs: false});

const props = defineProps({
    ...fieldProps,
});

const {shellProps} = useFieldShell(props);
</script>

<style>
.phone-field,
.phone-field .iti {
    width: 100%;
}

.phone-field .iti {
    display: block;
}

.phone-field .iti input.iti__tel-input {
    width: 100%;
    min-height: 3rem;
    box-sizing: border-box;
    border: 1px solid rgb(255 255 255 / 15%);
    border-radius: 0.75rem;
    background: transparent;
    color: #f3f4f6;
    padding: 0.75rem;
    outline: none;
    box-shadow: none;
    transition: border-color 150ms ease, box-shadow 150ms ease;
}

.phone-field .iti input.iti__tel-input:focus {
    border-color: #f59e0b;
    outline: 2px solid rgb(245 158 11 / 20%);
    outline-offset: 1px;
}

.phone-field.phone-field-invalid input.iti__tel-input {
    border-color: #f87171;
}
</style>
