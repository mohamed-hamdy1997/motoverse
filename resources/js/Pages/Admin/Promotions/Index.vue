<template>
    <ElPanel title="Promotions" description="Offers appear on the homepage while active and inside their date window.">
        <template #actions>
            <Link :href="route('admin.promotions.create')">
                <Button label="New promotion" icon="pi pi-plus"/>
            </Link>
        </template>

        <template #filters>
            <ElFilterBar :filters="filters" :selects="[{key: 'brand_id', placeholder: 'All brands', options: brands, optionLabel: 'name', optionValue: 'id'}]"/>
        </template>

        <ElDataTable :src="promotions" empty-title="No promotions found" empty-icon="pi pi-megaphone">
            <Column header="Promotion">
                <template #body="{data}">
                    <p class="font-semibold text-white">{{ data.title }}</p>
                    <p class="text-xs text-ink-400">{{ data.highlight }}</p>
                </template>
            </Column>
            <Column header="Brand">
                <template #body="{data}">
                    <ElBrandTag :name="data.brand.name" :color="data.brand.accent_color"/>
                </template>
            </Column>
            <Column header="Runs">
                <template #body="{data}">
                    <span class="text-sm tabular-nums text-ink-300">{{ data.starts_at }} → {{ data.ends_at }}</span>
                </template>
            </Column>
            <Column header="Status">
                <template #body="{data}">
                    <ElStatusBadge v-bind="statusOf(data)"/>
                </template>
            </Column>
            <Column header="" class="w-24">
                <template #body="{data}">
                    <ElRowActions :label="data.title" :edit-href="route('admin.promotions.edit', data.id)" :delete-href="route('admin.promotions.destroy', data.id)"/>
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

defineProps({
    promotions: {type: Object, required: true},
    brands: {type: Array, required: true},
    filters: {type: Object, default: () => ({})},
});

const statusOf = (promotion) => {
    if (!promotion.is_active) {
        return {label: 'Disabled', severity: 'neutral'};
    }

    return promotion.is_running
        ? {label: 'Live', severity: 'success'}
        : {label: 'Scheduled / ended', severity: 'warning'};
};
</script>
