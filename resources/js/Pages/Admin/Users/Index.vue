<template>
    <ElPanel title="Users" description="Admins manage every brand; data-entry users only manage the brands assigned to them.">
        <template #actions>
            <Link :href="route('admin.users.create')">
                <Button label="New user" icon="pi pi-user-plus"/>
            </Link>
        </template>

        <ElDataTable :src="users" empty-icon="pi pi-users">
            <Column header="Name">
                <template #body="{data}">
                    <p class="font-semibold text-white">{{ data.name }}</p>
                    <p class="text-xs text-ink-400">{{ data.email }}</p>
                </template>
            </Column>
            <Column header="Role">
                <template #body="{data}">
                    <ElStatusBadge :label="data.role_label" :severity="data.is_admin ? 'info' : 'neutral'"/>
                </template>
            </Column>
            <Column header="Brands">
                <template #body="{data}">
                    <span v-if="data.is_admin" class="text-sm text-ink-400">All brands</span>
                    <div v-else class="flex flex-wrap gap-1.5">
                        <ElBrandTag v-for="brand in data.brands" :key="brand.id" :name="brand.name" :color="brand.accent_color"/>
                    </div>
                </template>
            </Column>
            <Column header="" class="w-24">
                <template #body="{data}">
                    <ElRowActions
                        :label="data.name"
                        :edit-href="route('admin.users.edit', data.id)"
                        :delete-href="data.id === currentUserId ? null : route('admin.users.destroy', data.id)"
                    />
                </template>
            </Column>
        </ElDataTable>
    </ElPanel>
</template>

<script setup>
import {computed} from 'vue';
import {Link, usePage} from '@inertiajs/vue3';
import Button from 'primevue/button';
import Column from 'primevue/column';
import ElPanel from '@/Components/Main/ElPanel.vue';
import ElDataTable from '@/Components/Table/ElDataTable.vue';
import ElBrandTag from '@/Components/Brand/ElBrandTag.vue';
import ElRowActions from '@/Components/Admin/ElRowActions.vue';
import ElStatusBadge from '@/Components/Admin/ElStatusBadge.vue';

defineProps({
    users: {type: Object, required: true},
});

const currentUserId = computed(() => usePage().props.auth.user.id);
</script>
