import {reactive} from 'vue';

/**
 * Lightweight shared state that lets homepage sections hand off to each other,
 * e.g. "Test ride" on a model card pre-fills the enquiry form and scrolls to it.
 */
const state = reactive({
    lineupBrandId: null,
    financeMotorcycleId: null,
    enquiry: {type: null, motorcycleId: null, nonce: 0},
});

const scrollToSection = (id) => {
    document.getElementById(id)?.scrollIntoView({behavior: 'smooth', block: 'start'});
};

export function useHomeIntent() {
    const showLineup = (brandId = null) => {
        state.lineupBrandId = brandId;
        scrollToSection('models');
    };

    const requestEnquiry = (type, motorcycleId = null) => {
        state.enquiry = {type, motorcycleId, nonce: state.enquiry.nonce + 1};
        scrollToSection('test-ride');
    };

    const requestFinance = (motorcycleId) => {
        state.financeMotorcycleId = motorcycleId;
        scrollToSection('finance');
    };

    return {state, showLineup, requestEnquiry, requestFinance, scrollToSection};
}

/**
 * Group motorcycles by brand for PrimeVue grouped Select options.
 */
export const groupModelsByBrand = (brands) => brands
    .filter((brand) => brand.motorcycles?.length)
    .map((brand) => ({label: brand.name, color: brand.accent_color, items: brand.motorcycles}));
