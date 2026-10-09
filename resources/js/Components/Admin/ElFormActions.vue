<template>
    <div class="flex flex-wrap items-center justify-end gap-3 border-t border-white/5 pt-6">
        <Link :href="cancelHref">
            <Button label="Cancel" severity="secondary" text/>
        </Link>
        <ElSubmitButton :form="form" :text="submitText"/>
    </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';
import Button from 'primevue/button';
import ElSubmitButton from '@/Components/Buttons/ElSubmitButton.vue';

defineProps({
    form: {type: Object, required: true},
    cancelHref: {type: String, required: true},
    submitText: {type: String, default: 'Save'},
});
</script>
