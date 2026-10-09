<template>
    <div class="relative grid min-h-screen place-items-center overflow-hidden bg-ink-950 px-4 py-12">
        <img src="/images/brands/apex.jpg" alt="" class="absolute inset-0 h-full w-full object-cover opacity-20 blur-sm" aria-hidden="true">
        <div class="absolute inset-0 bg-gradient-to-b from-ink-950/60 via-ink-950/80 to-ink-950" aria-hidden="true"/>
        <main class="relative w-full max-w-md">
            <slot/>
        </main>
        <Toast position="bottom-right"/>
    </div>
</template>

<script setup>
import Toast from 'primevue/toast';
import {useFlashToast} from '@/Composables/useFlashToast.js';

useFlashToast();
</script>
