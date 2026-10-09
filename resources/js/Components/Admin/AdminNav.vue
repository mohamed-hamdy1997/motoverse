<template>
    <nav class="flex h-full flex-col gap-6 p-5" aria-label="Admin">
        <Link :href="route('admin.dashboard')" class="flex items-center gap-2" @click="$emit('navigate')">
            <ElLogo/>
        </Link>

        <div class="rounded-xl border border-white/5 bg-ink-850 p-3">
            <p class="text-[0.65rem] font-semibold uppercase tracking-[0.2em] text-ink-500">Access scope</p>
            <p v-if="user.is_admin" class="mt-1.5 text-sm text-ink-200">All brands</p>
            <div v-else class="mt-2 flex flex-wrap gap-1.5">
                <ElBrandTag v-for="brand in user.brands" :key="brand.id" :name="brand.name" :color="brand.accent_color"/>
            </div>
        </div>

        <ul class="flex flex-1 flex-col gap-1">
            <li v-for="item in visibleItems" :key="item.route">
                <Link
                    :href="route(item.route)"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
                    :class="isActive(item) ? 'bg-signal-500/10 text-signal-300' : 'text-ink-300 hover:bg-white/5 hover:text-white'"
                    :aria-current="isActive(item) ? 'page' : undefined"
                    @click="$emit('navigate')"
                >
                    <i :class="item.icon" class="w-4 text-center" aria-hidden="true"/>
                    {{ item.label }}
                </Link>
            </li>
        </ul>

        <p class="text-xs text-ink-500">MotoVerse CMS · v1.0</p>
    </nav>
</template>

<script setup>
import {computed} from 'vue';
import {Link, usePage} from '@inertiajs/vue3';
import ElLogo from '@/Components/Brand/ElLogo.vue';
import ElBrandTag from '@/Components/Brand/ElBrandTag.vue';

defineEmits(['navigate']);

const page = usePage();
const user = computed(() => page.props.auth.user);

const items = [
    {label: 'Dashboard', icon: 'pi pi-th-large', route: 'admin.dashboard', match: 'admin.dashboard'},
    {label: 'Brands', icon: 'pi pi-bookmark', route: 'admin.brands.index', match: 'admin.brands.*'},
    {label: 'Motorcycles', icon: 'pi pi-car', route: 'admin.motorcycles.index', match: 'admin.motorcycles.*'},
    {label: 'Promotions', icon: 'pi pi-megaphone', route: 'admin.promotions.index', match: 'admin.promotions.*'},
    {label: 'Enquiries', icon: 'pi pi-inbox', route: 'admin.enquiries.index', match: 'admin.enquiries.*'},
    {label: 'Users', icon: 'pi pi-users', route: 'admin.users.index', match: 'admin.users.*', adminOnly: true},
];

const visibleItems = computed(() => items.filter((item) => !item.adminOnly || user.value.is_admin));

const isActive = (item) => route().current(item.match);
</script>
