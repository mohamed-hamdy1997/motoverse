import {computed} from 'vue';

/**
 * Shared error resolution for El* form fields bound to an Inertia form via `form` + `name`.
 */
export function useFieldError(props) {
    const errorMessage = computed(() => props.customError ?? props.form?.errors?.[props.name] ?? null);
    const hasError = computed(() => !!errorMessage.value);

    return {errorMessage, hasError};
}

/**
 * Props every El* form field accepts.
 */
export const fieldProps = {
    form: {type: Object, required: true},
    name: {type: String, required: true},
    label: {type: String, default: null},
    required: {type: Boolean, default: false},
    disabled: {type: Boolean, default: false},
    customError: {type: String, default: null},
    hint: {type: String, default: null},
    variant: {type: String, default: 'on'},
};
