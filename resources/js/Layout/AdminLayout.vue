<template>
    <div class="min-h-screen bg-ink-950 lg:grid lg:grid-cols-[16rem_1fr]">
        <aside class="sticky top-0 hidden h-screen border-r border-white/5 bg-ink-900 lg:block">
            <AdminNav/>
        </aside>

        <Drawer v-model:visible="mobileNavOpen" class="!w-72 !border-white/5 !bg-ink-900" :show-close-icon="false">
            <template #container>
                <AdminNav @navigate="mobileNavOpen = false"/>
            </template>
        </Drawer>

        <div class="flex min-w-0 flex-col">
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-white/5 bg-ink-950/80 px-4 backdrop-blur sm:px-6">
                <div class="flex items-center gap-3">
                    <Button icon="pi pi-bars" text rounded class="lg:!hidden" aria-label="Open navigation" @click="mobileNavOpen = true"/>
                    <Link :href="route('home')" class="hidden items-center gap-2 text-sm text-ink-400 transition hover:text-white sm:flex">
                        <i class="pi pi-external-link text-xs" aria-hidden="true"/> View website
                    </Link>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden text-right sm:block">
                        <p class="text-sm font-semibold text-white">{{ user.name }}</p>
                        <p class="text-xs text-ink-400">{{ user.role_label }}</p>
                    </div>
                    <Avatar :label="initials" shape="circle" class="!bg-signal-500/15 !font-semibold !text-signal-300"/>
                    <Link
                        :href="route('admin.logout')"
                        method="post"
                        as="button"
                        class="grid h-9 w-9 cursor-pointer place-items-center rounded-full text-ink-400 transition hover:bg-white/5 hover:text-white"
                        aria-label="Sign out"
                        v-tooltip.bottom="'Sign out'"
                    >
                        <i class="pi pi-sign-out" aria-hidden="true"/>
                    </Link>
                </div>
            </header>

            <main id="main" class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                <slot/>
            </main>
        </div>

        <Toast position="bottom-right"/>
        <ConfirmDialog/>
    </div>
</template>

<script setup>
import {computed, ref} from 'vue';
import {Link, usePage} from '@inertiajs/vue3';
import Avatar from 'primevue/avatar';
import Button from 'primevue/button';
import ConfirmDialog from 'primevue/confirmdialog';
import Drawer from 'primevue/drawer';
import Toast from 'primevue/toast';
import AdminNav from '@/Components/Admin/AdminNav.vue';
import {useFlashToast} from '@/Composables/useFlashToast.js';

useFlashToast();

const page = usePage();
const mobileNavOpen = ref(false);
const user = computed(() => page.props.auth.user);
const initials = computed(() => user.value.name.split(' ').filter((part) => /^[a-z]/i.test(part)).map((part) => part[0]).slice(0, 2).join(''));
</script>
