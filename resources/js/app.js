import '../css/app.css';
import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true});
        return pages[`./Pages/${name}.vue`];
    },
    setup({el, App, props, plugin}) {
        createApp({ render: () => h(App, props)})
        .use(plugin)
        .mount(el);
    }
});
