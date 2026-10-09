import Aura from '@primeuix/themes/aura';
import {definePreset} from '@primeuix/themes';

/**
 * PrimeVue preset aligned with the Tailwind "ink" + "signal" tokens in app.css,
 * so PrimeVue widgets and hand-built Tailwind UI read as one dark system.
 */
export const MotoversePreset = definePreset(Aura, {
    primitive: {
        borderRadius: {
            none: '0',
            xs: '4px',
            sm: '6px',
            md: '10px',
            lg: '14px',
            xl: '18px',
        },
        signal: {
            50: '#fff4ed',
            100: '#ffe5d4',
            200: '#ffc8a8',
            300: '#ffb08a',
            400: '#ff8a55',
            500: '#ff6b2c',
            600: '#e85414',
            700: '#bf410b',
            800: '#983511',
            900: '#7a2e11',
            950: '#421406',
        },
        ink: {
            0: '#ffffff',
            50: '#f5f6f7',
            100: '#e8e9eb',
            200: '#c9ccd1',
            300: '#a3a8b0',
            400: '#7c828c',
            500: '#5b616b',
            600: '#3b4048',
            700: '#272b32',
            800: '#1a1d22',
            900: '#0f1113',
            950: '#0a0b0d',
        },
    },
    semantic: {
        primary: {
            50: '{signal.50}',
            100: '{signal.100}',
            200: '{signal.200}',
            300: '{signal.300}',
            400: '{signal.400}',
            500: '{signal.500}',
            600: '{signal.600}',
            700: '{signal.700}',
            800: '{signal.800}',
            900: '{signal.900}',
            950: '{signal.950}',
        },
        colorScheme: {
            dark: {
                surface: {
                    0: '#ffffff',
                    50: '{ink.50}',
                    100: '{ink.100}',
                    200: '{ink.200}',
                    300: '{ink.300}',
                    400: '{ink.400}',
                    500: '{ink.500}',
                    600: '{ink.600}',
                    700: '{ink.700}',
                    800: '{ink.800}',
                    900: '{ink.900}',
                    950: '{ink.950}',
                },
                primary: {
                    color: '{signal.500}',
                    contrastColor: '{ink.950}',
                    hoverColor: '{signal.400}',
                    activeColor: '{signal.600}',
                },
                highlight: {
                    background: 'color-mix(in srgb, {signal.500}, transparent 84%)',
                    focusBackground: 'color-mix(in srgb, {signal.500}, transparent 76%)',
                    color: '{signal.300}',
                    focusColor: '{signal.200}',
                },
                formField: {
                    background: '{ink.900}',
                    filledBackground: '{ink.900}',
                    borderColor: '{ink.700}',
                    hoverBorderColor: '{ink.500}',
                    focusBorderColor: '{signal.500}',
                    color: '{ink.100}',
                    placeholderColor: '{ink.400}',
                    floatLabelColor: '{ink.400}',
                    floatLabelFocusColor: '{signal.400}',
                    floatLabelActiveColor: '{ink.300}',
                },
                content: {
                    background: '{ink.900}',
                    hoverBackground: '{ink.800}',
                    borderColor: '{ink.700}',
                    color: '{ink.100}',
                },
                overlay: {
                    select: {background: '{ink.800}', borderColor: '{ink.700}', color: '{ink.100}'},
                    popover: {background: '{ink.800}', borderColor: '{ink.700}', color: '{ink.100}'},
                    modal: {background: '{ink.900}', borderColor: '{ink.700}', color: '{ink.100}'},
                },
            },
        },
    },
});
