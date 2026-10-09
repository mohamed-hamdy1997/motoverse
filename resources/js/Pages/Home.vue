<template>
    <Head title="Four brands. One ride culture."/>

    <SiteHeader/>

    <main id="main">
        <HeroSection :brands="brands" :country-count="countryCount"/>
        <MarqueeStrip/>
        <BrandUniverse :brands="brands"/>
        <LineupSection :brands="brands"/>
        <PromotionsSection :promotions="promotions"/>
        <ServicesSection/>
        <FinanceSection :brands="brands"/>
        <ShowroomsSection :showrooms="showrooms"/>
        <EnquirySection :brands="brands" :showrooms="showrooms" :enquiry-types="enquiryTypes"/>
    </main>

    <SiteFooter :brands="brands"/>
</template>

<script setup>
import {computed} from 'vue';
import {Head} from '@inertiajs/vue3';
import SiteHeader from '@/Components/Home/SiteHeader.vue';
import HeroSection from '@/Components/Home/HeroSection.vue';
import MarqueeStrip from '@/Components/Home/MarqueeStrip.vue';
import BrandUniverse from '@/Components/Home/BrandUniverse.vue';
import LineupSection from '@/Components/Home/LineupSection.vue';
import PromotionsSection from '@/Components/Home/PromotionsSection.vue';
import ServicesSection from '@/Components/Home/ServicesSection.vue';
import FinanceSection from '@/Components/Home/FinanceSection.vue';
import ShowroomsSection from '@/Components/Home/ShowroomsSection.vue';
import EnquirySection from '@/Components/Home/EnquirySection.vue';
import SiteFooter from '@/Components/Home/SiteFooter.vue';

const props = defineProps({
    brands: {type: Array, required: true},
    promotions: {type: Array, required: true},
    showrooms: {type: Array, required: true},
    enquiryTypes: {type: Array, required: true},
});

const countryCount = computed(() => new Set(props.showrooms.map((showroom) => showroom.country)).size);
</script>
