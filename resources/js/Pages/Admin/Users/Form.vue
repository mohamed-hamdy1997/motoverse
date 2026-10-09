<template>
    <ElPanel :title="user ? `Edit ${user.name}` : 'New user'">
        <form class="grid max-w-3xl gap-6 sm:grid-cols-2" novalidate @submit.prevent="submit">
            <ElFloatingInput :form="form" name="name" label="Full name" required/>
            <ElFloatingInput :form="form" name="email" label="Email" type="email" required/>
            <ElFloatingDropdown :form="form" name="role" label="Role" :options="roles" option-label="label" option-value="value" required/>
            <ElFloatingMultiSelect
                v-if="form.role === 'data_entry'"
                :form="form"
                name="brand_ids"
                label="Assigned brands"
                :options="brands"
                required
            />
            <p v-else class="self-center text-sm text-ink-400">Admins can manage every brand.</p>
            <ElFloatingPassword :form="form" name="password" label="Password" autocomplete="new-password" :required="!user" :hint="user ? 'Leave empty to keep the current password.' : null"/>
            <ElFloatingPassword :form="form" name="password_confirmation" label="Confirm password" autocomplete="new-password" :required="!user"/>

            <ElFormActions class="sm:col-span-2" :form="form" :cancel-href="route('admin.users.index')" :submit-text="user ? 'Save changes' : 'Create user'"/>
        </form>
    </ElPanel>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3';
import ElPanel from '@/Components/Main/ElPanel.vue';
import ElFloatingInput from '@/Components/Form/ElFloatingInput.vue';
import ElFloatingDropdown from '@/Components/Form/ElFloatingDropdown.vue';
import ElFloatingMultiSelect from '@/Components/Form/ElFloatingMultiSelect.vue';
import ElFloatingPassword from '@/Components/Form/ElFloatingPassword.vue';
import ElFormActions from '@/Components/Admin/ElFormActions.vue';
import {useResourceForm} from '@/Composables/useResourceForm.js';

const props = defineProps({
    user: {type: Object, default: null},
    roles: {type: Array, required: true},
    brands: {type: Array, required: true},
});

const form = useForm({
    name: props.user?.name ?? '',
    email: props.user?.email ?? '',
    role: props.user?.role ?? 'data_entry',
    brand_ids: props.user?.brand_ids ?? [],
    password: '',
    password_confirmation: '',
});

const submit = useResourceForm(form, 'admin.users', props.user?.id);
</script>
