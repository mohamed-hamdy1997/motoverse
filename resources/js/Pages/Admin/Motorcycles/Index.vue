<template>
    <ElPanel title="Motorcycles" description="The model line-up displayed on the homepage, scoped to the brands you manage.">
        <template #actions>
            <Link :href="route('admin.motorcycles.create')">
                <Button label="New motorcycle" icon="pi pi-plus"/>
            </Link>
        </template>

        <template #filters>
            <ElFilterBar :filters="filters" :selects="[{key: 'brand_id', placeholder: 'All brands', options: brands, optionLabel: 'name', optionValue: 'id'}]"/>
        </template>

        <ElDataTable :src="motorcycles" empty-title="No motorcycles found" empty-icon="pi pi-car">
            <Column header="Model">
                <template #body="{data}">
                    <div class="flex items-center gap-3">
                        <img v-if="data.image_url" :src="data.image_url" alt="" class="h-11 w-16 rounded-md object-cover">
                        <span v-else class="grid h-11 w-16 place-items-center rounded-md bg-white/5 text-ink-500"><i class="pi pi-image" aria-hidden="true"/></span>
                        <div>
                            <p class="font-semibold text-white">{{ data.name }}</p>
                            <p class="text-xs text-ink-400">{{ data.category_label }}</p>
                        </div>
                    </div>
                </template>
            </Column>
            <Column header="Brand">
                <template #body="{data}">
                    <ElBrandTag :name="data.brand.name" :color="data.brand.accent_color"/>
                </template>
            </Column>
            <Column header="Specs">
                <template #body="{data}">
                    <span class="text-sm text-ink-300">{{ data.is_electric ? 'Electric' : `${data.engine_cc} cc` }} · {{ data.power_hp }} hp</span>
                </template>
            </Column>
            <Column header="Price">
                <template #body="{data}"><ElPrice :value="data.price" class="text-ink-100"/></template>
            </Column>
            <Column header="Status">
                <template #body="{data}">
                    <div class="flex flex-wrap gap-1.5">
                        <ElStatusBadge :label="data.is_published ? 'Published' : 'Draft'" :severity="data.is_published ? 'success' : 'neutral'"/>
                        <ElStatusBadge v-if="data.is_featured" label="Featured" severity="warning"/>
                    </div>
                </template>
            </Column>
            <Column header="" class="w-24">
                <template #body="{data}">
                    <ElRowActions :label="data.name" :edit-href="route('admin.motorcycles.edit', data.id)" :delete-href="route('admin.motorcycles.destroy', data.id)"/>
                </template>
            </Column>
        </ElDataTable>
    </ElPanel>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';
import Button from 'primevue/button';
import Column from 'primevue/column';
import ElPanel from '@/Components/Main/ElPanel.vue';
import ElDataTable from '@/Components/Table/ElDataTable.vue';
import ElFilterBar from '@/Components/Admin/ElFilterBar.vue';
import ElBrandTag from '@/Components/Brand/ElBrandTag.vue';
import ElRowActions from '@/Components/Admin/ElRowActions.vue';
import ElStatusBadge from '@/Components/Admin/ElStatusBadge.vue';
import ElPrice from '@/Components/Text/ElPrice.vue';

defineProps({
    motorcycles: {type: Object, required: true},
    brands: {type: Array, required: true},
    filters: {type: Object, default: () => ({})},
});
</script>
