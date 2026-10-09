<template>
    <div class="flex flex-col items-center justify-center gap-3 px-6 py-14 text-center">
        <span class="grid h-14 w-14 place-items-center rounded-2xl bg-white/5 text-ink-400">
            <i :class="icon" class="text-2xl" aria-hidden="true"/>
        </span>
        <h3 class="font-semibold text-white">{{ title }}</h3>
        <p class="max-w-sm text-sm text-ink-400">{{ message }}</p>
        <slot/>
    </div>
</template>

<script setup>
defineProps({
    title: {type: String, default: 'Nothing here yet'},
    message: {type: String, default: 'Records you add will appear in this list.'},
    icon: {type: String, default: 'pi pi-inbox'},
});
</script>
