<template>
    <DataTable
        v-if="rows.length"
        :value="rows"
        :lazy="isPaginated"
        :paginator="isPaginated && meta.last_page > 1"
        :rows="meta?.per_page ?? rows.length"
        :total-records="meta?.total ?? rows.length"
        :first="meta ? (meta.current_page - 1) * meta.per_page : 0"
        :loading="loading"
        data-key="id"
        striped-rows
        scrollable
        paginator-template="PrevPageLink PageLinks NextPageLink CurrentPageReport"
        current-page-report-template="{first}–{last} of {totalRecords}"
        :pt="{
            root: 'overflow-hidden rounded-xl border border-white/5',
            column: {headerCell: '!bg-ink-850 !text-xs !uppercase !tracking-wider !text-ink-400'},
        }"
        @page="onPage"
    >
        <slot/>
    </DataTable>

    <EmptyData v-else :title="emptyTitle" :message="emptyMessage" :icon="emptyIcon">
        <slot name="empty"/>
    </EmptyData>
</template>

<script setup>
import {computed, ref} from 'vue';
import {router} from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import EmptyData from '@/Components/EmptyData.vue';

/**
 * Thin wrapper around PrimeVue DataTable that understands Laravel resource
 * collections — plain arrays or paginated `{data, meta, links}` payloads.
 */
const props = defineProps({
    src: {type: [Object, Array], required: true},
    emptyTitle: {type: String, default: undefined},
    emptyMessage: {type: String, default: undefined},
    emptyIcon: {type: String, default: undefined},
});

const loading = ref(false);
const rows = computed(() => (Array.isArray(props.src) ? props.src : props.src.data ?? []));
const meta = computed(() => (Array.isArray(props.src) ? null : props.src.meta));
const isPaginated = computed(() => !!meta.value);

const onPage = (event) => {
    router.reload({
        data: {page: event.page + 1},
        preserveScroll: true,
        onStart: () => (loading.value = true),
        onFinish: () => (loading.value = false),
    });
};
</script>
