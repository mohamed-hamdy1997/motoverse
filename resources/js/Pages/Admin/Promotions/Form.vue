<template>
    <ElPanel :title="promotion ? `Edit ${promotion.title}` : 'New promotion'">
        <form class="grid max-w-3xl gap-6 sm:grid-cols-2" novalidate @submit.prevent="submit">
            <ElFloatingDropdown :form="form" name="brand_id" label="Brand" :options="brands" required/>
            <ElFloatingInput :form="form" name="highlight" label="Badge text" maxlength="40" hint="Short, e.g. “0% APR · 24 mo”" required/>
            <ElFloatingInput :form="form" name="title" label="Title" class="sm:col-span-2" required/>
            <ElFloatingTextarea :form="form" name="description" label="Description" :rows="3" class="sm:col-span-2" required/>
            <ElFloatingDatePicker :form="form" name="starts_at" label="Starts on" required/>
            <ElFloatingDatePicker :form="form" name="ends_at" label="Ends on" required/>
            <ElFormInputSwitch :form="form" name="is_active" label="Active"/>

            <ElFormActions class="sm:col-span-2" :form="form" :cancel-href="route('admin.promotions.index')" :submit-text="promotion ? 'Save changes' : 'Create promotion'"/>
        </form>
    </ElPanel>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3';
import ElPanel from '@/Components/Main/ElPanel.vue';
import ElFloatingInput from '@/Components/Form/ElFloatingInput.vue';
import ElFloatingDropdown from '@/Components/Form/ElFloatingDropdown.vue';
import ElFloatingTextarea from '@/Components/Form/ElFloatingTextarea.vue';
import ElFloatingDatePicker from '@/Components/Form/ElFloatingDatePicker.vue';
import ElFormInputSwitch from '@/Components/Form/ElFormInputSwitch.vue';
import ElFormActions from '@/Components/Admin/ElFormActions.vue';
import {useResourceForm} from '@/Composables/useResourceForm.js';

const props = defineProps({
    promotion: {type: Object, default: null},
    brands: {type: Array, required: true},
});

const form = useForm({
    brand_id: props.promotion?.brand_id ?? (props.brands.length === 1 ? props.brands[0].id : null),
    title: props.promotion?.title ?? '',
    highlight: props.promotion?.highlight ?? '',
    description: props.promotion?.description ?? '',
    starts_at: props.promotion?.starts_at ?? null,
    ends_at: props.promotion?.ends_at ?? null,
    is_active: props.promotion?.is_active ?? true,
});

const submit = useResourceForm(form, 'admin.promotions', props.promotion?.id);
</script>
