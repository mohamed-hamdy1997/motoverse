<template>
    <Head :title="content.title"/>

    <main id="main" class="relative isolate grid min-h-screen place-items-center overflow-hidden px-4 text-center">
        <img src="/images/brands/nomad.jpg" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-15" aria-hidden="true">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-ink-950/70 to-ink-950" aria-hidden="true"/>
        <div>
            <p class="font-display text-[clamp(6rem,20vw,12rem)] font-bold leading-none text-signal-500">{{ status }}</p>
            <h1 class="heading-display mt-2 text-4xl sm:text-5xl">{{ content.title }}</h1>
            <p class="mx-auto mt-4 max-w-md text-ink-300">{{ content.message }}</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <Link :href="route('home')" class="btn-primary">Back to the website</Link>
                <Link v-if="$page.props.auth?.user" :href="route('admin.dashboard')" class="btn-ghost">Admin dashboard</Link>
            </div>
        </div>
    </main>
</template>

<script setup>
import {computed} from 'vue';
import {Head, Link} from '@inertiajs/vue3';

const props = defineProps({
    status: {type: Number, required: true},
});

const messages = {
    403: {title: 'Off-limits', message: 'Your account is not allowed to access this content. It may belong to a brand you are not assigned to.'},
    404: {title: 'Wrong turn', message: 'The page you are looking for does not exist or has moved.'},
    500: {title: 'Engine trouble', message: 'Something went wrong on our side. Please try again in a moment.'},
    503: {title: 'In the workshop', message: 'We are doing some maintenance. Please check back shortly.'},
};

const content = computed(() => messages[props.status] ?? messages[500]);
</script>
