<template>
    <ElPanel :title="motorcycle ? `Edit ${motorcycle.name}` : 'New motorcycle'" description="Leave engine capacity empty for electric models.">
        <form class="grid gap-6 lg:grid-cols-3" novalidate @submit.prevent="submit">
            <div class="grid gap-6 sm:grid-cols-2 lg:col-span-2">
                <ElFloatingDropdown :form="form" name="brand_id" label="Brand" :options="brands" required/>
                <ElFloatingInput :form="form" name="name" label="Model name" required/>
                <ElFloatingDropdown :form="form" name="category" label="Category" :options="categories" option-label="label" option-value="value" required/>
                <ElFloatingNumber :form="form" name="price" label="Price" prefix="QAR " :max="9999999" required/>
                <ElFloatingNumber :form="form" name="engine_cc" label="Engine" suffix=" cc" :use-grouping="false" :max="3000" hint="Empty = electric"/>
                <ElFloatingNumber :form="form" name="power_hp" label="Power" suffix=" hp" :max="400" required/>
                <ElFloatingNumber :form="form" name="weight_kg" label="Weight" suffix=" kg" :max="600" required/>
                <ElFloatingTextarea :form="form" name="description" label="Description" :rows="4" class="sm:col-span-2"/>
                <ElFormInputSwitch :form="form" name="is_published" label="Published on the website"/>
                <ElFormInputSwitch :form="form" name="is_featured" label="Featured model"/>
            </div>
            <ElImageUpload :form="form" name="image" label="Product image" :current-url="motorcycle?.image_url"/>

            <ElFormActions class="lg:col-span-3" :form="form" :cancel-href="route('admin.motorcycles.index')" :submit-text="motorcycle ? 'Save changes' : 'Create motorcycle'"/>
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
import ElImageUpload from '@/Components/Form/ElImageUpload.vue';
import ElFormActions from '@/Components/Admin/ElFormActions.vue';
import {useResourceForm} from '@/Composables/useResourceForm.js';

const props = defineProps({
    motorcycle: {type: Object, default: null},
    brands: {type: Array, required: true},
    categories: {type: Array, required: true},
});

const form = useForm({
    brand_id: props.motorcycle?.brand_id ?? (props.brands.length === 1 ? props.brands[0].id : null),
    name: props.motorcycle?.name ?? '',
    category: props.motorcycle?.category ?? null,
    price: props.motorcycle?.price ?? null,
    engine_cc: props.motorcycle?.engine_cc ?? null,
    power_hp: props.motorcycle?.power_hp ?? null,
    weight_kg: props.motorcycle?.weight_kg ?? null,
    description: props.motorcycle?.description ?? '',
    is_published: props.motorcycle?.is_published ?? true,
    is_featured: props.motorcycle?.is_featured ?? false,
    image: null,
});

const submit = useResourceForm(form, 'admin.motorcycles', props.motorcycle?.id);
</script>
