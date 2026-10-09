<template>
    <header
        class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
        :class="scrolled ? 'border-b border-white/5 bg-ink-950/85 backdrop-blur-lg' : 'bg-transparent'"
    >
        <div class="container-site flex h-18 items-center justify-between gap-6 py-4">
            <a href="#top" aria-label="MotoVerse — back to top">
                <ElLogo/>
            </a>

            <nav class="hidden lg:block" aria-label="Main">
                <ul class="flex items-center gap-1">
                    <li v-for="item in navItems" :key="item.href">
                        <a :href="item.href" class="rounded-full px-4 py-2 text-sm font-medium text-ink-200 transition hover:bg-white/5 hover:text-white">
                            {{ item.label }}
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="flex items-center gap-2">
                <a href="#test-ride" class="btn-primary hidden !px-5 !py-2.5 sm:inline-flex">
                    <i class="pi pi-calendar text-xs" aria-hidden="true"/> Book a test ride
                </a>
                <button
                    type="button"
                    class="grid h-11 w-11 cursor-pointer place-items-center rounded-full border border-white/10 text-white lg:hidden"
                    aria-label="Open menu"
                    :aria-expanded="menuOpen"
                    aria-controls="mobile-menu"
                    @click="menuOpen = true"
                >
                    <i class="pi pi-bars" aria-hidden="true"/>
                </button>
            </div>
        </div>

        <Drawer v-model:visible="menuOpen" position="right" class="!w-full !max-w-sm !border-white/5 !bg-ink-950" :show-close-icon="false">
            <template #container="{closeCallback}">
                <div id="mobile-menu" class="flex h-full flex-col p-6">
                    <div class="flex items-center justify-between">
                        <ElLogo/>
                        <button type="button" class="grid h-11 w-11 cursor-pointer place-items-center rounded-full border border-white/10 text-white" aria-label="Close menu" @click="closeCallback">
                            <i class="pi pi-times" aria-hidden="true"/>
                        </button>
                    </div>
                    <nav class="mt-10 flex-1" aria-label="Mobile">
                        <ul class="flex flex-col">
                            <li v-for="(item, index) in navItems" :key="item.href" class="border-b border-white/5">
                                <a :href="item.href" class="flex items-center justify-between py-4 font-display text-3xl font-semibold uppercase text-white" @click="closeCallback">
                                    {{ item.label }}
                                    <span class="text-sm text-ink-500">0{{ index + 1 }}</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <a href="#test-ride" class="btn-primary w-full" @click="closeCallback">Book a test ride</a>
                </div>
            </template>
        </Drawer>
    </header>
</template>

<script setup>
import {onBeforeUnmount, onMounted, ref} from 'vue';
import Drawer from 'primevue/drawer';
import ElLogo from '@/Components/Brand/ElLogo.vue';

const navItems = [
    {label: 'Brands', href: '#brands'},
    {label: 'Models', href: '#models'},
    {label: 'Offers', href: '#offers'},
    {label: 'Services', href: '#services'},
    {label: 'Finance', href: '#finance'},
    {label: 'Showrooms', href: '#showrooms'},
];

const scrolled = ref(false);
const menuOpen = ref(false);

const onScroll = () => {
    scrolled.value = window.scrollY > 24;
};

onMounted(() => {
    onScroll();
    window.addEventListener('scroll', onScroll, {passive: true});
});

onBeforeUnmount(() => window.removeEventListener('scroll', onScroll));
</script>
