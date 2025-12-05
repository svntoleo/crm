import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

// Ensure a safe runtime `route()` helper exists to avoid console errors
(function ensureRoute() {
    const w = window as any;
    if (typeof w.route !== 'function') {
        w.route = (name: string, params?: any) => {
            // Fallback: convert dot-notated route name to a path
            // e.g. 'customers.show' -> '/customers/show/ID' (best-effort)
            let path = '/' + String(name).replace(/\./g, '/');
            if (params !== undefined && params !== null) {
                if (typeof params === 'object') {
                    const id = params.id ?? Object.values(params).find((v: any) => typeof v === 'number' || typeof v === 'string');
                    if (id !== undefined) path += `/${id}`;
                } else {
                    path += `/${String(params)}`;
                }
            }

            return path;
        };
    }
})();
