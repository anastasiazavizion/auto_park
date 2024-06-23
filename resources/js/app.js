import './bootstrap';
import '../css/app.css';

import {computed, createApp, h, ref} from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import i18n from './i18n/index'; // import your i18n instance

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

import MainLayout from '@/Layouts/MainLayout.vue';
import { i18nVue } from 'laravel-vue-i18n';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

 createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        const page = pages[`./Pages/${name}.vue`]
        page.default.layout = page.default.layout || MainLayout
        return page
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .component('VueDatePicker', VueDatePicker)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
