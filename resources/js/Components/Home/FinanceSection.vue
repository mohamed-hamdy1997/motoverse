<template>
    <section id="finance" class="relative isolate overflow-hidden py-20 sm:py-28" aria-labelledby="finance-heading">
        <img src="/images/sections/finance.jpg" alt="" loading="lazy" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-25" aria-hidden="true">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-ink-950 via-ink-950/85 to-ink-950" aria-hidden="true"/>

        <div class="container-site grid items-center gap-14 lg:grid-cols-2">
            <div v-reveal>
                <p class="eyebrow">Financing</p>
                <h2 id="finance-heading" class="heading-display mt-4 text-5xl sm:text-6xl lg:text-7xl">Ride now.<br>Pay your way.</h2>
                <p class="mt-6 max-w-lg text-base leading-relaxed text-ink-300">
                    Estimate your monthly instalment in seconds, then let our finance desk find the best plan with our partner banks.
                </p>
                <ul class="mt-8 grid gap-4 sm:grid-cols-2">
                    <li v-for="perk in perks" :key="perk.title" class="flex gap-3">
                        <i :class="perk.icon" class="mt-1 text-signal-400" aria-hidden="true"/>
                        <div>
                            <p class="font-semibold text-white">{{ perk.title }}</p>
                            <p class="text-sm text-ink-400">{{ perk.copy }}</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="rounded-3xl border border-white/10 bg-ink-900/80 p-6 shadow-2xl shadow-black/50 backdrop-blur-xl sm:p-8" v-reveal="120">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="font-display text-2xl font-bold uppercase text-white">Payment estimator</h3>
                    <span class="rounded-full bg-white/5 px-3 py-1 text-xs text-ink-400">{{ annualRate }}% p.a. indicative</span>
                </div>

                <div class="mt-6 grid gap-6">
                    <div>
                        <label for="finance-model" class="mb-2 block text-sm text-ink-300">Model</label>
                        <Select
                            v-model="state.financeMotorcycleId"
                            input-id="finance-model"
                            :options="modelGroups"
                            option-group-label="label"
                            option-group-children="items"
                            option-label="name"
                            option-value="id"
                            placeholder="Choose a model"
                            class="w-full"
                        >
                            <template #optiongroup="{option}">
                                <span class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider" :style="{color: option.color}">{{ option.label }}</span>
                            </template>
                        </Select>
                    </div>

                    <div>
                        <div class="mb-3 flex items-center justify-between text-sm">
                            <label for="finance-down" class="text-ink-300">Down payment</label>
                            <span class="font-semibold text-white">{{ downPaymentPercent }}% · <ElPrice :value="downPayment"/></span>
                        </div>
                        <Slider v-model="downPaymentPercent" :min="10" :max="50" :step="5" aria-labelledby="finance-down" class="w-full"/>
                        <span id="finance-down" class="sr-only">Down payment percentage</span>
                    </div>

                    <div>
                        <p id="finance-term" class="mb-2 text-sm text-ink-300">Term (months)</p>
                        <SelectButton
                            v-model="termMonths"
                            :options="terms"
                            option-label="label"
                            option-value="value"
                            :allow-empty="false"
                            aria-labelledby="finance-term"
                            class="w-full [&>*]:flex-1"
                        />
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-2 gap-4 rounded-2xl bg-ink-950/70 p-5">
                    <div class="col-span-2">
                        <p class="text-xs uppercase tracking-wider text-ink-500">Estimated monthly</p>
                        <p class="font-display text-6xl font-bold text-signal-500" aria-live="polite"><ElPrice :value="monthly"/></p>
                    </div>
                    <div>
                        <p class="text-xs text-ink-500">Financed amount</p>
                        <p class="font-semibold text-ink-100"><ElPrice :value="financedAmount"/></p>
                    </div>
                    <div>
                        <p class="text-xs text-ink-500">Total payable</p>
                        <p class="font-semibold text-ink-100"><ElPrice :value="totalPayable"/></p>
                    </div>
                </div>

                <button type="button" class="btn-primary mt-6 w-full" :disabled="!selectedModel" @click="requestEnquiry('finance', state.financeMotorcycleId)">
                    Apply for this plan <i class="pi pi-arrow-right text-xs" aria-hidden="true"/>
                </button>
                <p class="mt-3 text-center text-xs text-ink-500">Illustrative only. Final terms subject to credit approval.</p>
            </div>
        </div>
    </section>
</template>

<script setup>
import {computed, ref} from 'vue';
import Select from 'primevue/select';
import SelectButton from 'primevue/selectbutton';
import Slider from 'primevue/slider';
import ElPrice from '@/Components/Text/ElPrice.vue';
import {monthlyInstalment} from '@/Helpers/format.js';
import {groupModelsByBrand, useHomeIntent} from '@/Composables/useHomeIntent.js';

const props = defineProps({
    brands: {type: Array, required: true},
});

const {state, requestEnquiry} = useHomeIntent();

const annualRate = 3.99;
const terms = [12, 24, 36, 48, 60].map((value) => ({value, label: String(value)}));
const perks = [
    {icon: 'pi pi-calendar', title: '12–60 months', copy: 'Flexible terms that fit your budget.'},
    {icon: 'pi pi-check-circle', title: 'Approval in 24h', copy: 'Fast decisions with partner banks.'},
    {icon: 'pi pi-moon', title: 'Islamic finance', copy: 'Shariah-compliant Murabaha plans.'},
    {icon: 'pi pi-sync', title: 'Trade-in ready', copy: 'Use your current bike as deposit.'},
];

const modelGroups = computed(() => groupModelsByBrand(props.brands));
const allModels = computed(() => props.brands.flatMap((brand) => brand.motorcycles));

if (state.financeMotorcycleId === null) {
    state.financeMotorcycleId = allModels.value.find((motorcycle) => motorcycle.is_featured)?.id ?? allModels.value[0]?.id ?? null;
}

const downPaymentPercent = ref(20);
const termMonths = ref(36);

const selectedModel = computed(() => allModels.value.find((motorcycle) => motorcycle.id === state.financeMotorcycleId));
const price = computed(() => selectedModel.value?.price ?? 0);
const downPayment = computed(() => price.value * downPaymentPercent.value / 100);
const financedAmount = computed(() => price.value - downPayment.value);
const monthly = computed(() => monthlyInstalment(financedAmount.value, annualRate, termMonths.value));
const totalPayable = computed(() => downPayment.value + monthly.value * termMonths.value);
</script>
