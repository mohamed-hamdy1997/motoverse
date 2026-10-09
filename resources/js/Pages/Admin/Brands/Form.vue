<template>
    <ElPanel :title="brand ? `Edit ${brand.name}` : 'New brand'" description="Brand content appears in the “Our brands” section of the homepage.">
        <form class="grid gap-6 lg:grid-cols-3" novalidate @submit.prevent="submit">
            <div class="grid gap-6 lg:col-span-2 sm:grid-cols-2">
                <ElFloatingInput :form="form" name="name" label="Brand name" required/>
                <ElFloatingDropdown :form="form" name="segment" label="Market segment" :options="segments" option-label="label" option-value="value" required/>
                <ElFloatingInput :form="form" name="tagline" label="Tagline" class="sm:col-span-2" required/>
                <ElFloatingTextarea :form="form" name="description" label="Description" :rows="4" class="sm:col-span-2" required/>
                <ElColorInput :form="form" name="accent_color" label="Accent colour" required/>
                <ElFloatingNumber :form="form" name="sort_order" label="Display order" :max="999" hint="Lower numbers appear first."/>
                <ElFormInputSwitch :form="form" name="is_active" label="Visible on the website"/>
            </div>
            <ElImageUpload :form="form" name="cover_image" label="Cover image" :current-url="brand?.cover_image_url"/>

            <ElFormActions class="lg:col-span-3" :form="form" :cancel-href="route('admin.brands.index')" :submit-text="brand ? 'Save changes' : 'Create brand'"/>
        </form>
    </ElPanel>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3';
import ElPanel from '@/Components/Main/ElPanel.vue';
import ElFloatingInput from '@/Components/Form/ElFloatingInput.vue';
import ElFloatingDropdown from '@/Components/Form/ElFloatingDropdown.vue';
import ElFloatingTextarea from '@/Components/Form/ElFloatingTextarea.vue';
import ElFloatingNumber from '@/Components/Form/ElFloatingNumber.vue';
import ElFormInputSwitch from '@/Components/Form/ElFormInputSwitch.vue';
import ElColorInput from '@/Components/Form/ElColorInput.vue';
import ElImageUpload from '@/Components/Form/ElImageUpload.vue';
import ElFormActions from '@/Components/Admin/ElFormActions.vue';
import {useResourceForm} from '@/Composables/useResourceForm.js';

const props = defineProps({
    brand: {type: Object, default: null},
    segments: {type: Array, required: true},
});

const form = useForm({
    name: props.brand?.name ?? '',
    segment: props.brand?.segment ?? null,
    tagline: props.brand?.tagline ?? '',
    description: props.brand?.description ?? '',
    accent_color: props.brand?.accent_color ?? '#ff6b2c',
    sort_order: props.brand?.sort_order ?? 0,
    is_active: props.brand?.is_active ?? true,
    cover_image: null,
});

const submit = useResourceForm(form, 'admin.brands', props.brand?.id);
</script>
