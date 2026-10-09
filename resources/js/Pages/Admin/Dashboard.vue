<template>
    <ElPanel title="Dashboard" :description="`Welcome back, ${user.name}. Here's what's happening across your ${user.is_admin ? 'brands' : 'assigned brands'}.`" :padded="false">
        <div class="grid gap-6">
            <section class="grid grid-cols-2 gap-3 lg:grid-cols-4" aria-label="Key figures">
                <article v-for="card in statCards" :key="card.label" class="card-surface p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-400">{{ card.label }}</p>
                        <i :class="card.icon" class="text-ink-500" aria-hidden="true"/>
                    </div>
                    <p class="mt-3 font-display text-4xl font-bold text-white tabular-nums">{{ card.value }}</p>
                </article>
            </section>

            <div class="grid gap-6 lg:grid-cols-5">
                <section class="card-surface p-5 lg:col-span-2" aria-labelledby="brands-heading">
                    <h2 id="brands-heading" class="font-semibold text-white">Brands in scope</h2>
                    <ul class="mt-4 divide-y divide-white/5">
                        <li v-for="brand in brands" :key="brand.id" class="flex items-center justify-between gap-3 py-3">
                            <div class="flex items-center gap-3">
                                <span class="h-8 w-1 rounded-full" :style="{background: brand.accent_color}" aria-hidden="true"/>
                                <div>
                                    <p class="font-medium text-white">{{ brand.name }}</p>
                                    <p class="text-xs text-ink-400">{{ brand.segment_label }}</p>
                                </div>
                            </div>
                            <p class="text-right text-xs text-ink-400">
                                <span class="block text-sm font-semibold text-ink-100">{{ brand.motorcycles_count }} models</span>
                                {{ brand.promotions_count }} live offers
                            </p>
                        </li>
                    </ul>
                </section>

                <section class="card-surface p-5 lg:col-span-3" aria-labelledby="enquiries-heading">
                    <div class="flex items-center justify-between">
                        <h2 id="enquiries-heading" class="font-semibold text-white">Latest enquiries</h2>
                        <Link :href="route('admin.enquiries.index')" class="text-sm text-signal-400 hover:underline">View all</Link>
                    </div>
                    <ul v-if="latestEnquiries.length" class="mt-4 divide-y divide-white/5">
                        <li v-for="enquiry in latestEnquiries" :key="enquiry.id" class="flex flex-wrap items-center justify-between gap-2 py-3">
                            <div>
                                <p class="font-medium text-white">{{ enquiry.name }}</p>
                                <p class="text-xs text-ink-400">
                                    {{ enquiry.type_label }}<template v-if="enquiry.motorcycle"> · {{ enquiry.motorcycle.name }}</template> · {{ enquiry.created_at_human }}
                                </p>
                            </div>
                            <ElBrandTag v-if="enquiry.brand" :name="enquiry.brand.name" :color="enquiry.brand.accent_color"/>
                        </li>
                    </ul>
                    <EmptyData v-else title="No enquiries yet" message="Customer requests from the website will land here." />
                </section>
            </div>
        </div>
    </ElPanel>
</template>

<script setup>
import {computed} from 'vue';
import {Link, usePage} from '@inertiajs/vue3';
import ElPanel from '@/Components/Main/ElPanel.vue';
import ElBrandTag from '@/Components/Brand/ElBrandTag.vue';
import EmptyData from '@/Components/EmptyData.vue';

const props = defineProps({
    stats: {type: Object, required: true},
    brands: {type: Array, required: true},
    latestEnquiries: {type: Array, required: true},
});

const user = computed(() => usePage().props.auth.user);

const statCards = computed(() => [
    {label: 'Brands', value: props.stats.brands, icon: 'pi pi-bookmark'},
    {label: 'Models', value: props.stats.motorcycles, icon: 'pi pi-car'},
    {label: 'Live offers', value: props.stats.promotions, icon: 'pi pi-megaphone'},
    {label: 'New enquiries', value: props.stats.new_enquiries, icon: 'pi pi-inbox'},
]);
</script>
