import '../css/app.css';
import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import Tooltip from 'primevue/tooltip';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/index.esm.js';
import {MotoversePreset} from '@/theme.js';
import {reveal} from '@/directive/RevealDirective.js';
import PublicLayout from '@/Layout/PublicLayout.vue';
import AdminLayout from '@/Layout/AdminLayout.vue';
import GuestLayout from '@/Layout/GuestLayout.vue';

const appName = import.meta.env.VITE_APP_NAME || 'MotoVerse';
const pages = import.meta.glob('./Pages/**/*.vue');

/**
 * Resolve a page and attach its default layout based on the page namespace.
 */
const resolvePage = async (name) => {
    const importPage = pages[`./Pages/${name}.vue`];

    if (!importPage) {
        throw new Error(`Page not found: ${name}`);
    }

    const page = await importPage();

    if (page.default.layout === undefined) {
        page.default.layout = name === 'Error' ? null : name.startsWith('Admin/')
            ? AdminLayout
            : name.startsWith('Auth/') ? GuestLayout : PublicLayout;
    }

    return page;
};

createInertiaApp({
    title: (title) => (title ? `${title} · ${appName}` : appName),
    resolve: resolvePage,
    progress: {color: '#ff6b2c'},
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: MotoversePreset,
                    options: {
                        darkModeSelector: '.dark',
                        cssLayer: {name: 'primevue', order: 'theme, base, primevue, components, utilities'},
                    },
                },
                ripple: false,
            })
            .use(ToastService)
            .use(ConfirmationService)
            .directive('tooltip', Tooltip)
            .directive('reveal', reveal)
            .mount(el);
    },
});
