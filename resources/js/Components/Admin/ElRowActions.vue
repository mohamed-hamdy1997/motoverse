<template>
    <div class="flex items-center justify-end gap-1">
        <Link
            v-if="editHref"
            :href="editHref"
            class="grid h-8 w-8 place-items-center rounded-full text-ink-300 transition hover:bg-white/5 hover:text-white"
            :aria-label="`Edit ${label}`"
            v-tooltip.top="'Edit'"
        >
            <i class="pi pi-pencil text-sm" aria-hidden="true"/>
        </Link>
        <button
            v-if="deleteHref"
            type="button"
            class="grid h-8 w-8 cursor-pointer place-items-center rounded-full text-ink-300 transition hover:bg-red-500/10 hover:text-red-400"
            :aria-label="`Delete ${label}`"
            v-tooltip.top="'Delete'"
            @click="confirmDelete(deleteHref, label)"
        >
            <i class="pi pi-trash text-sm" aria-hidden="true"/>
        </button>
    </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';
import {useDeleteConfirm} from '@/Composables/useDeleteConfirm.js';

defineProps({
    label: {type: String, required: true},
    editHref: {type: String, default: null},
    deleteHref: {type: String, default: null},
});

const confirmDelete = useDeleteConfirm();
</script>
