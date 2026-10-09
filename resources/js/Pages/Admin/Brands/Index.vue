<template>
    <ElPanel title="Brands" description="Brand identity shown on the public website: name, segment, accent colour and cover image.">
        <template #actions>
            <Link v-if="canCreate" :href="route('admin.brands.create')">
                <Button label="New brand" icon="pi pi-plus"/>
            </Link>
        </template>

        <ElDataTable :src="brands" empty-title="No brands" empty-icon="pi pi-bookmark">
            <Column header="Brand">
                <template #body="{data}">
                    <div class="flex items-center gap-3">
                        <img v-if="data.cover_image_url" :src="data.cover_image_url" alt="" class="h-10 w-16 rounded-md object-cover">
                        <div>
                            <p class="font-semibold text-white">{{ data.name }}</p>
                            <p class="text-xs text-ink-400">{{ data.tagline }}</p>
                        </div>
                    </div>
                </template>
            </Column>
            <Column header="Segment" field="segment_label"/>
            <Column header="Accent">
                <template #body="{data}">
                    <ElBrandTag :name="data.accent_color" :color="data.accent_color"/>
                </template>
            </Column>
            <Column header="Content">
                <template #body="{data}">
                    <span class="text-sm text-ink-300">{{ data.motorcycles_count }} models · {{ data.promotions_count }} offers</span>
                </template>
            </Column>
            <Column header="Status">
                <template #body="{data}">
                    <ElStatusBadge :label="data.is_active ? 'Active' : 'Hidden'" :severity="data.is_active ? 'success' : 'neutral'"/>
                </template>
            </Column>
            <Column header="" class="w-24">
                <template #body="{data}">
                    <ElRowActions
                        :label="data.name"
                        :edit-href="route('admin.brands.edit', data.id)"
                        :delete-href="canCreate ? route('admin.brands.destroy', data.id) : null"
                    />
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
import ElBrandTag from '@/Components/Brand/ElBrandTag.vue';
import ElRowActions from '@/Components/Admin/ElRowActions.vue';
import ElStatusBadge from '@/Components/Admin/ElStatusBadge.vue';

defineProps({
    brands: {type: Array, required: true},
    canCreate: {type: Boolean, default: false},
});
</script>
