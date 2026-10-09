import {watch} from 'vue';
import {usePage} from '@inertiajs/vue3';
import {useToast} from 'primevue/usetoast';

/**
 * Surfaces Laravel session flash messages (shared by HandleInertiaRequests) as PrimeVue toasts.
 */
export function useFlashToast() {
    const page = usePage();
    const toast = useToast();

    watch(() => page.props.flash, (flash) => {
        if (flash?.success) {
            toast.add({severity: 'success', summary: 'Done', detail: flash.success, life: 4000});
        }

        if (flash?.error) {
            toast.add({severity: 'error', summary: 'Something went wrong', detail: flash.error, life: 6000});
        }
    }, {immediate: true});
}
