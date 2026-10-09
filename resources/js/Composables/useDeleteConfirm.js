import {router} from '@inertiajs/vue3';
import {useConfirm} from 'primevue/useconfirm';

/**
 * Confirm-then-delete helper used by every admin index page.
 */
export function useDeleteConfirm() {
    const confirm = useConfirm();

    return (url, label) => {
        confirm.require({
            header: 'Confirm deletion',
            message: `Delete “${label}”? This cannot be undone.`,
            icon: 'pi pi-trash',
            rejectProps: {label: 'Cancel', severity: 'secondary', outlined: true},
            acceptProps: {label: 'Delete', severity: 'danger'},
            accept: () => router.delete(url, {preserveScroll: true}),
        });
    };
}
