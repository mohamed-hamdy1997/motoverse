import {computed, useAttrs} from 'vue';
import {fieldProps, useFieldError} from '@/Composables/useFieldError.js';

export {fieldProps};

/**
 * Splits a field's attributes: `class` styles the outer wrapper (so grid
 * utilities like `sm:col-span-2` work), everything else goes to the input.
 */
export function useFieldShell(props) {
    const attrs = useAttrs();
    const {errorMessage, hasError} = useFieldError(props);

    const shellProps = computed(() => ({
        label: props.label ?? props.name,
        required: props.required,
        variant: props.variant,
        hint: props.hint,
        hasError: hasError.value,
        errorMessage: errorMessage.value,
        class: attrs.class,
    }));

    const inputAttrs = computed(() => {
        const {class: _wrapperClass, ...rest} = attrs;
        return rest;
    });

    return {shellProps, inputAttrs};
}
