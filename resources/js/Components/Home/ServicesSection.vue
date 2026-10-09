<template>
    <section id="services" class="bg-ink-900/40 py-20 sm:py-28" aria-labelledby="services-heading">
        <div class="container-site">
            <SectionHeading id="services-heading" eyebrow="Ownership, handled" lead="One account for everything after the handshake — across every brand and every showroom.">
                More than<br>the motorcycle.
            </SectionHeading>

            <div class="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <article class="group relative isolate flex min-h-[26rem] flex-col justify-end overflow-hidden rounded-3xl border border-white/5 p-8 sm:col-span-2 lg:col-span-1 lg:row-span-2" v-reveal>
                    <img src="/images/sections/service.jpg" alt="A technician working on a motorcycle in a MotoVerse service bay" loading="lazy" class="absolute inset-0 -z-20 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950 via-ink-950/60 to-transparent" aria-hidden="true"/>
                    <span class="grid h-12 w-12 place-items-center rounded-2xl bg-signal-500 text-ink-950"><i class="pi pi-wrench text-lg" aria-hidden="true"/></span>
                    <h3 class="heading-display mt-5 text-4xl">Service &amp; maintenance</h3>
                    <p class="mt-3 text-sm leading-relaxed text-ink-300">
                        Factory-trained technicians, genuine parts and live repair updates on WhatsApp. Free pick-up and drop-off in Doha.
                    </p>
                    <button type="button" class="btn-primary mt-6 self-start" @click="requestEnquiry('service')">Book a service</button>
                </article>

                <article
                    v-for="(service, index) in services"
                    :key="service.title"
                    v-reveal="index * 60"
                    class="group flex flex-col rounded-3xl border border-white/5 bg-ink-900 p-7 transition duration-300 hover:border-signal-500/30 hover:bg-ink-850"
                >
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-white/5 text-signal-400 transition group-hover:bg-signal-500 group-hover:text-ink-950">
                        <i :class="service.icon" aria-hidden="true"/>
                    </span>
                    <h3 class="mt-5 text-lg font-semibold text-white">{{ service.title }}</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-ink-400">{{ service.copy }}</p>
                    <button v-if="service.action" type="button" class="mt-5 inline-flex cursor-pointer items-center gap-2 self-start text-sm font-semibold text-ink-200 transition hover:gap-3 hover:text-white" @click="service.action">
                        {{ service.cta }} <i class="pi pi-arrow-right text-xs text-signal-400" aria-hidden="true"/>
                    </button>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
import SectionHeading from '@/Components/Home/SectionHeading.vue';
import {useHomeIntent} from '@/Composables/useHomeIntent.js';

const {requestEnquiry, scrollToSection} = useHomeIntent();

const services = [
    {icon: 'pi pi-shopping-bag', title: 'Sales & trade-in', copy: 'Transparent pricing and instant trade-in valuations on any brand.', cta: 'Talk to sales', action: () => requestEnquiry('sales')},
    {icon: 'pi pi-calendar', title: 'Test rides', copy: '30-minute guided rides with full gear provided — no obligation.', cta: 'Book a ride', action: () => requestEnquiry('test_ride')},
    {icon: 'pi pi-percentage', title: 'Financing', copy: 'Conventional and Islamic (Murabaha) plans from 12 to 60 months.', cta: 'Estimate payments', action: () => scrollToSection('finance')},
    {icon: 'pi pi-box', title: 'Parts & accessories', copy: 'Genuine parts, riding gear and luggage — fitted while you wait.', cta: 'Ask for a part', action: () => requestEnquiry('service')},
    {icon: 'pi pi-shield', title: 'Warranty support', copy: 'Up to 3 years manufacturer warranty, honoured at every service centre.', cta: 'Warranty claim', action: () => requestEnquiry('service')},
    {icon: 'pi pi-headphones', title: 'Customer care', copy: '24/7 roadside assistance and a dedicated advisor for every owner.', cta: 'Call 800 MOTO', action: () => (window.location.href = 'tel:8006686')},
    {icon: 'pi pi-graduation-cap', title: 'Rider academy', copy: 'Licence preparation, desert riding and track-day coaching.', cta: 'Join a course', action: () => requestEnquiry('sales')},
];
</script>
