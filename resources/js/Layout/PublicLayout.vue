<template>
    <div class="min-h-screen bg-ink-950">
        <a href="#main" class="sr-only z-[100] rounded-full bg-signal-500 px-4 py-2 font-semibold text-ink-950 focus:not-sr-only focus:fixed focus:left-4 focus:top-4">
            Skip to content
        </a>
        <slot/>
        <Toast position="bottom-right"/>
    </div>
</template>

<script setup>
import Toast from 'primevue/toast';
import {useFlashToast} from '@/Composables/useFlashToast.js';

useFlashToast();
</script>
