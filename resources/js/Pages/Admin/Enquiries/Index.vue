<template>
    <ElPanel title="Enquiries" description="Test-ride, sales, finance and service requests submitted from the website.">
        <template #filters>
            <ElFilterBar
                :filters="filters"
                :searchable="false"
                :selects="[
                    {key: 'status', placeholder: 'Any status', options: statuses},
                    {key: 'type', placeholder: 'Any type', options: types},
                ]"
            />
        </template>

        <ElDataTable :src="enquiries" empty-title="No enquiries" empty-message="Nothing matches these filters yet." empty-icon="pi pi-inbox">
            <Column header="Customer">
                <template #body="{data}">
                    <p class="font-semibold text-white">{{ data.name }}</p>
                    <a :href="`mailto:${data.email}`" class="block text-xs text-ink-400 hover:text-signal-300">{{ data.email }}</a>
                    <a :href="`tel:${data.phone}`" class="block text-xs text-ink-400 hover:text-signal-300">{{ data.phone }}</a>
                </template>
            </Column>
            <Column header="Request">
                <template #body="{data}">
                    <p class="text-sm text-ink-100">{{ data.type_label }}<template v-if="data.motorcycle"> · {{ data.motorcycle.name }}</template></p>
                    <p v-if="data.preferred_date || data.showroom" class="text-xs text-ink-400">
                        <template v-if="data.preferred_date">{{ data.preferred_date }}</template>
                        <template v-if="data.showroom"> @ {{ data.showroom.name }}</template>
                    </p>
                    <p v-if="data.message" class="mt-1 max-w-xs truncate text-xs text-ink-500" :title="data.message">“{{ data.message }}”</p>
                </template>
            </Column>
            <Column header="Brand">
                <template #body="{data}">
                    <ElBrandTag v-if="data.brand" :name="data.brand.name" :color="data.brand.accent_color"/>
                    <span v-else class="text-xs text-ink-500">General</span>
                </template>
            </Column>
            <Column header="Received">
                <template #body="{data}"><span class="text-sm text-ink-300" :title="data.created_at">{{ data.created_at_human }}</span></template>
            </Column>
            <Column header="Status" class="w-44">
                <template #body="{data}">
                    <Select
                        :model-value="data.status"
                        :options="statuses"
                        option-label="label"
                        option-value="value"
                        size="small"
                        class="w-full"
                        :aria-label="`Status for ${data.name}`"
                        @update:model-value="(status) => updateStatus(data, status)"
                    />
                </template>
            </Column>
            <Column v-if="user.is_admin" header="" class="w-16">
                <template #body="{data}">
                    <ElRowActions :label="`enquiry from ${data.name}`" :delete-href="route('admin.enquiries.destroy', data.id)"/>
                </template>
            </Column>
        </ElDataTable>
    </ElPanel>
</template>

<script setup>
import {computed} from 'vue';
import {router, usePage} from '@inertiajs/vue3';
import Column from 'primevue/column';
import Select from 'primevue/select';
import ElPanel from '@/Components/Main/ElPanel.vue';
import ElDataTable from '@/Components/Table/ElDataTable.vue';
import ElFilterBar from '@/Components/Admin/ElFilterBar.vue';
import ElBrandTag from '@/Components/Brand/ElBrandTag.vue';
import ElRowActions from '@/Components/Admin/ElRowActions.vue';

defineProps({
    enquiries: {type: Object, required: true},
    statuses: {type: Array, required: true},
    types: {type: Array, required: true},
    filters: {type: Object, default: () => ({})},
});

const user = computed(() => usePage().props.auth.user);

const updateStatus = (enquiry, status) => {
    router.put(route('admin.enquiries.update', enquiry.id), {status}, {preserveScroll: true});
};
</script>
