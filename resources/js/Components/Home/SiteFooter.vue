<template>
    <footer class="border-t border-white/5 bg-ink-950 pt-20" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="container-site grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <ElLogo/>
                <p class="mt-5 max-w-sm text-sm leading-relaxed text-ink-400">
                    MotoVerse Group represents four motorcycle brands across the GCC, with showrooms and service centres in Qatar, the UAE, Saudi Arabia and Kuwait.
                </p>
                <ul class="mt-6 flex gap-2" aria-label="Social media">
                    <li v-for="social in socials" :key="social.label">
                        <a :href="social.href" target="_blank" class="grid h-10 w-10 place-items-center rounded-full border border-white/10 text-ink-300 transition hover:border-signal-500 hover:text-signal-400" :aria-label="social.label">
                            <i :class="social.icon" aria-hidden="true"/>
                        </a>
                    </li>
                </ul>
            </div>

            <nav class="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:col-span-8" aria-label="Footer">
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-ink-500">Brands</h3>
                    <ul class="mt-5 space-y-3 text-sm">
                        <li v-for="brand in brands" :key="brand.id">
                            <a href="#brands" class="flex items-center gap-2 text-ink-300 hover:text-white">
                                <span class="h-1.5 w-1.5 rounded-full" :style="{background: brand.accent_color}" aria-hidden="true"/>
                                {{ brand.name }}
                                <span class="text-ink-600">· {{ brand.segment_label }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-ink-500">Explore</h3>
                    <ul class="mt-5 space-y-3 text-sm">
                        <li v-for="link in exploreLinks" :key="link.href">
                            <a :href="link.href" class="text-ink-300 hover:text-white">{{ link.label }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-ink-500">Contact</h3>
                    <ul class="mt-5 space-y-3 text-sm text-ink-300">
                        <li><a href="tel:8006686" class="hover:text-white">800 MOTO (6686)</a></li>
                        <li><a href="mailto:hello@motoverse.example" class="hover:text-white">hello@motoverse.example</a></li>
                        <li>24/7 roadside assistance</li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container-site mt-16 flex flex-col gap-4 border-t border-white/5 py-8 text-xs text-ink-500 md:flex-row md:items-center md:justify-between">
            <p>© {{ year }} MotoVerse. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#top" class="hover:text-ink-200">Back to top ↑</a>
                <Link :href="route('login')" class="hover:text-ink-200">Staff login</Link>
            </div>
        </div>
    </footer>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';
import ElLogo from '@/Components/Brand/ElLogo.vue';

defineProps({
    brands: {type: Array, required: true},
});

const year = new Date().getFullYear();

const exploreLinks = [
    {label: 'Models', href: '#models'},
    {label: 'Current offers', href: '#offers'},
    {label: 'Services', href: '#services'},
    {label: 'Financing', href: '#finance'},
    {label: 'Showrooms', href: '#showrooms'},
    {label: 'Book a test ride', href: '#test-ride'},
];

const socials = [
    {label: 'Instagram', icon: 'pi pi-instagram', href: '#'},
    {label: 'YouTube', icon: 'pi pi-youtube', href: '#'},
    {label: 'TikTok', icon: 'pi pi-tiktok', href: '#'},
    {label: 'LinkedIn', icon: 'pi pi-linkedin', href: 'https://www.linkedin.com/in/mohamed-hamdy-355969159'},
    {label: 'WhatsApp', icon: 'pi pi-whatsapp', href: 'https://wa.me/201150005671'},
];
</script>
