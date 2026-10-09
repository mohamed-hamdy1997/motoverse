<template>
    <form class="flex w-full flex-wrap items-center gap-3" role="search" @submit.prevent="apply">
        <IconField v-if="searchable" class="w-full sm:w-72">
            <InputIcon class="pi pi-search"/>
            <InputText v-model="state.search" placeholder="Search…" class="w-full" aria-label="Search"/>
        </IconField>
        <Select
            v-for="filter in selects"
            :key="filter.key"
            v-model="state[filter.key]"
            :options="filter.options"
            :option-label="filter.optionLabel ?? 'label'"
            :option-value="filter.optionValue ?? 'value'"
            :placeholder="filter.placeholder"
            :aria-label="filter.placeholder"
            show-clear
            class="w-full sm:w-52"
            @change="apply"
        />
        <Button v-if="searchable" type="submit" label="Search" severity="secondary" outlined/>
    </form>
</template>

<script setup>
import {reactive} from 'vue';
import {router} from '@inertiajs/vue3';
import Button from 'primevue/button';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';

/**
 * Query-string driven filters for admin index pages.
 */
const props = defineProps({
    filters: {type: Object, default: () => ({})},
    searchable: {type: Boolean, default: true},
    selects: {type: Array, default: () => []},
});

const state = reactive({
    search: props.filters.search ?? '',
    ...Object.fromEntries(props.selects.map((filter) => [filter.key, castFilterValue(props.filters[filter.key])])),
});

function castFilterValue(value) {
    if (value === undefined || value === null || value === '') {
        return null;
    }

    return /^\d+$/.test(value) ? Number(value) : value;
}

const apply = () => {
    const query = Object.fromEntries(Object.entries(state).filter(([, value]) => value !== null && value !== ''));
    router.get(window.location.pathname, query, {preserveState: true, preserveScroll: true, replace: true});
};
</script>
