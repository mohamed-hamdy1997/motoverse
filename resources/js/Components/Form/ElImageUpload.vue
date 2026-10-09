<template>
    <div>
        <span class="mb-1.5 block text-xs font-medium text-ink-400">{{ label }}</span>
        <label
            :for="id"
            class="group relative flex aspect-[16/9] w-full cursor-pointer items-center justify-center overflow-hidden rounded-xl border border-dashed transition"
            :class="hasError ? 'border-red-400/60' : 'border-ink-600 hover:border-signal-500/70'"
        >
            <img v-if="previewUrl" :src="previewUrl" alt="" class="absolute inset-0 h-full w-full object-cover opacity-80 transition group-hover:opacity-50">
            <span class="relative flex flex-col items-center gap-2 rounded-lg bg-ink-950/70 px-4 py-3 text-center text-sm text-ink-200 backdrop-blur">
                <i class="pi pi-image text-xl text-signal-400" aria-hidden="true"/>
                {{ previewUrl ? 'Replace image' : 'Upload image' }}
                <span class="text-xs text-ink-400">JPG, PNG or WebP · max 4 MB</span>
            </span>
            <input :id="id" type="file" accept="image/jpeg,image/png,image/webp" class="sr-only" @change="onChange">
        </label>
        <ElTextError v-if="hasError" :value="errorMessage"/>
    </div>
</template>

<script setup>
import {onBeforeUnmount, ref, useId} from 'vue';
import ElTextError from '@/Components/Text/ElTextError.vue';
import {fieldProps, useFieldError} from '@/Composables/useFieldError.js';

const props = defineProps({
    ...fieldProps,
    currentUrl: {type: String, default: null},
});

const id = useId();
const {errorMessage, hasError} = useFieldError(props);
const previewUrl = ref(props.currentUrl);
let objectUrl = null;

const onChange = (event) => {
    const [file] = event.target.files;

    if (!file) {
        return;
    }

    props.form[props.name] = file;

    if (objectUrl) {
        URL.revokeObjectURL(objectUrl);
    }

    objectUrl = URL.createObjectURL(file);
    previewUrl.value = objectUrl;
};

onBeforeUnmount(() => objectUrl && URL.revokeObjectURL(objectUrl));
</script>
