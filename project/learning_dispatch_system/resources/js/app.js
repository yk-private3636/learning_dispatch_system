import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
// Vuetify のインポートを追加 **********/
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

import { aliases, mdi } from 'vuetify/iconsets/mdi-svg';

import BackGround from './component/Layout.vue'


const vuetify = createVuetify({
  components,
  directives,
  icons: {
       defaultSet: 'mdi',
       aliases,
       sets: {
           mdi,
       },
   },
})

createInertiaApp({
    // resolve: (name) =>
    //     resolvePageComponent(
    //         `./views/${name}.vue`,
    //         import.meta.glob("./views/**/*.vue")
    //     )
    resolve: name => {
        const pages = import.meta.glob('./views/**/*.vue', { eager: true })
        let page = pages[`./views/${name}.vue`];
        page.default.layout = page.default.layout || BackGround
        return page
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.config.globalProperties.route = route;
        app.use(plugin)
        app.use(vuetify)
        app.mount(el);
    },
});