import './bootstrap';
import '../css/app.css';
import 'v-calendar/style.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { setupCalendar, Calendar, DatePicker } from 'v-calendar';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const app = createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(setupCalendar, {})
            .component('VCalendar', Calendar)
            .component('VDatePicker', DatePicker)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
