<template>
    <Head title="Staff sign in"/>

    <div class="card-surface p-8 shadow-2xl shadow-black/50 sm:p-10">
        <Link :href="route('home')" class="inline-block" aria-label="Back to the website">
            <ElLogo/>
        </Link>

        <h1 class="mt-8 font-display text-4xl font-bold uppercase text-white">Staff sign in</h1>
        <p class="mt-2 text-sm text-ink-400">Manage brands, models, promotions and customer enquiries.</p>

        <form class="mt-8 flex flex-col gap-6" novalidate @submit.prevent="submit">
            <ElFloatingInput :form="form" name="email" label="Email address" type="email" autocomplete="username" required autofocus/>
            <ElFloatingPassword :form="form" name="password" label="Password" autocomplete="current-password" required/>

            <label class="flex items-center gap-2 text-sm text-ink-300">
                <Checkbox v-model="form.remember" binary input-id="remember"/>
                <span>Keep me signed in</span>
            </label>

            <ElSubmitButton :form="form" text="Sign in" icon="pi pi-sign-in" class="w-full"/>
        </form>

        <div v-if="$page.props.appEnv !== 'production'" class="mt-8 rounded-xl border border-dashed border-white/10 p-4 text-xs leading-relaxed text-ink-400">
            <p class="mb-2 font-semibold uppercase tracking-wider text-ink-300">Demo accounts · password “password”</p>
            <ul class="space-y-1">
                <li v-for="account in demoAccounts" :key="account.email">
                    <button type="button" class="cursor-pointer text-signal-300 hover:underline" @click="useAccount(account.email)">{{ account.email }}</button>
                    — {{ account.scope }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import Checkbox from 'primevue/checkbox';
import ElLogo from '@/Components/Brand/ElLogo.vue';
import ElFloatingInput from '@/Components/Form/ElFloatingInput.vue';
import ElFloatingPassword from '@/Components/Form/ElFloatingPassword.vue';
import ElSubmitButton from '@/Components/Buttons/ElSubmitButton.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const demoAccounts = [
    {email: 'admin@motoverse.test', scope: 'Admin, all brands'},
    {email: 'editor@motoverse.test', scope: 'Data entry, Volta + Nomad'},
    {email: 'apex@motoverse.test', scope: 'Data entry, Apex'},
];

const useAccount = (email) => {
    form.email = email;
    form.password = 'password';
};

const submit = () => {
    form.post(route('login.store'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
