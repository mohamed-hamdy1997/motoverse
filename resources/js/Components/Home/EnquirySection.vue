<template>
    <section id="test-ride" class="bg-ink-900/40 py-20 sm:py-28" aria-labelledby="enquiry-heading">
        <div class="container-site">
            <div class="grid overflow-hidden rounded-[2rem] border border-white/5 bg-ink-900 lg:grid-cols-5">
                <div class="relative isolate flex min-h-80 flex-col justify-end p-8 sm:p-12 lg:col-span-2">
                    <img src="/images/sections/test-ride.jpg" alt="A rider silhouetted against a desert sunset" loading="lazy" class="absolute inset-0 -z-20 h-full w-full object-cover">
                    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950 via-ink-950/50 to-ink-950/10" aria-hidden="true"/>
                    <p class="eyebrow">Test rides & enquiries</p>
                    <h2 id="enquiry-heading" class="heading-display mt-4 text-5xl sm:text-6xl">Feel it<br>for yourself.</h2>
                    <ul class="mt-8 space-y-3 text-sm text-ink-200">
                        <li v-for="point in sellingPoints" :key="point" class="flex items-center gap-3">
                            <span class="grid h-6 w-6 place-items-center rounded-full bg-signal-500/15 text-signal-400"><i class="pi pi-check text-[0.65rem]" aria-hidden="true"/></span>
                            {{ point }}
                        </li>
                    </ul>
                </div>

                <div class="p-6 sm:p-12 lg:col-span-3">
                    <Transition mode="out-in" enter-from-class="opacity-0 translate-y-2" enter-active-class="transition duration-300" leave-to-class="opacity-0" leave-active-class="transition duration-200">
                        <div v-if="submitted" key="success" class="flex h-full flex-col items-center justify-center py-16 text-center" role="status">
                            <span class="grid h-16 w-16 place-items-center rounded-full bg-signal-500 text-ink-950"><i class="pi pi-check text-2xl" aria-hidden="true"/></span>
                            <h3 class="heading-display mt-6 text-4xl">Request received</h3>
                            <p class="mt-3 max-w-sm text-ink-300">Thank you! A MotoVerse advisor will call you within one working day to confirm the details.</p>
                            <button type="button" class="btn-ghost mt-8" @click="submitted = false">Send another request</button>
                        </div>

                        <form v-else key="form" class="grid gap-6 sm:grid-cols-2" novalidate @submit.prevent="submit">
                            <fieldset class="sm:col-span-2">
                                <legend class="mb-3 text-sm text-ink-300">I'd like to…</legend>
                                <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
                                    <label
                                        v-for="type in enquiryTypes"
                                        :key="type.value"
                                        class="flex cursor-pointer items-center justify-center rounded-xl border px-3 py-2.5 text-center text-sm font-medium transition has-[:focus-visible]:outline-2 has-[:focus-visible]:outline-signal-500"
                                        :class="form.type === type.value ? 'border-signal-500 bg-signal-500/10 text-white' : 'border-white/10 text-ink-300 hover:border-white/25'"
                                    >
                                        <input v-model="form.type" type="radio" name="enquiry-type" :value="type.value" class="sr-only">
                                        {{ type.label }}
                                    </label>
                                </div>
                            </fieldset>

                            <ElFloatingDropdown
                                :form="form"
                                name="motorcycle_id"
                                label="Model"
                                :options="modelGroups"
                                option-group-label="label"
                                option-group-children="items"
                                :required="form.type === 'test_ride'"
                                clearable
                                filter
                            >
                                <template #optiongroup="{option}">
                                    <span class="text-xs font-semibold uppercase tracking-wider" :style="{color: option.color}">{{ option.label }}</span>
                                </template>
                            </ElFloatingDropdown>
                            <ElFloatingDropdown :form="form" name="showroom_id" label="Preferred showroom" :options="showroomOptions" clearable/>

                            <ElFloatingInput :form="form" name="name" label="Full name" autocomplete="name" required/>
                            <ElFloatingInput :form="form" name="phone" label="Mobile number" type="tel" autocomplete="tel" required/>
                            <ElFloatingInput :form="form" name="email" label="Email address" type="email" autocomplete="email" required/>
                            <ElFloatingDatePicker :form="form" name="preferred_date" label="Preferred date" :min-date="today"/>
                            <ElFloatingTextarea :form="form" name="message" label="Anything we should know? (optional)" :rows="3" class="sm:col-span-2"/>

                            <div class="flex flex-col-reverse items-start justify-between gap-4 sm:col-span-2 sm:flex-row sm:items-center">
                                <p class="text-xs text-ink-500">We only use your details to respond to this request.</p>
                                <button type="submit" class="btn-primary !px-8 !py-3.5" :disabled="form.processing">
                                    <i v-if="form.processing" class="pi pi-spin pi-spinner" aria-hidden="true"/>
                                    {{ submitLabel }}
                                </button>
                            </div>
                        </form>
                    </Transition>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import {computed, ref, watch} from 'vue';
import {useForm} from '@inertiajs/vue3';
import ElFloatingInput from '@/Components/Form/ElFloatingInput.vue';
import ElFloatingDropdown from '@/Components/Form/ElFloatingDropdown.vue';
import ElFloatingDatePicker from '@/Components/Form/ElFloatingDatePicker.vue';
import ElFloatingTextarea from '@/Components/Form/ElFloatingTextarea.vue';
import {groupModelsByBrand, useHomeIntent} from '@/Composables/useHomeIntent.js';

const props = defineProps({
    brands: {type: Array, required: true},
    showrooms: {type: Array, required: true},
    enquiryTypes: {type: Array, required: true},
});

const {state} = useHomeIntent();
const submitted = ref(false);
const today = new Date();

const sellingPoints = ['30-minute guided ride on your chosen model', 'Helmet, jacket and gloves provided', 'Trade-in valuation on the spot', 'No obligation, no pressure'];

const form = useForm({
    type: 'test_ride',
    motorcycle_id: null,
    showroom_id: null,
    name: '',
    email: '',
    phone: '',
    preferred_date: null,
    message: '',
});

const modelGroups = computed(() => groupModelsByBrand(props.brands));
const showroomOptions = computed(() => props.showrooms.map((showroom) => ({id: showroom.id, name: `${showroom.name} — ${showroom.city}`})));
const submitLabel = computed(() => form.type === 'test_ride' ? 'Book my test ride' : 'Send request');

// Pre-fill from other sections ("Test ride" on a model card, "Apply" in the finance estimator…)
watch(() => state.enquiry.nonce, () => {
    submitted.value = false;
    form.type = state.enquiry.type ?? form.type;
    form.motorcycle_id = state.enquiry.motorcycleId ?? form.motorcycle_id;
    form.clearErrors();
});

const submit = () => {
    form.post(route('enquiries.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            submitted.value = true;
        },
    });
};
</script>
