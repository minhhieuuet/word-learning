/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import Vue from 'vue';
Vue.config.silent = true

import './common/filters';
import Clipboard from 'v-clipboard'
import VeeValidate, { Validator } from 'vee-validate';
import draggable from 'vuedraggable'
import VueRouter from 'vue-router';
import Routers from './configs/routes';
import VueMaterial from 'vue-material';
import VModal from 'vue-js-modal';
import Toasted from 'vue-toasted';
import vue2Dropzone from 'vue2-dropzone';
import VueLazyload from 'vue-lazyload';
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import VueHtmlToPaper from 'vue-html-to-paper';

// import 'vue-material/dist/vue-material.min.css';

// import GlobalComponents from './globalComponents';
// import GlobalDirectives from './globalDirectives';
// import Notifications from './components/NotificationPlugin';

// // MaterialDashboard plugin
import MaterialDashboard from './material-dashboard';

import Chartist from 'chartist';
import DataTable from './components/datatable/DataTable';
import 'ant-design-vue/dist/antd.css';
import Antd from 'ant-design-vue';
import VueSwal from 'vue-swal'
import Multiselect from 'vue-multiselect'
import 'animate.css/animate.css';

Vue.use(Clipboard)
// register globally
Vue.config.productionTip = true;


Vue.component('multiselect', Multiselect)
Vue.use(VueSwal)
Vue.use(VueLazyload, {
    loading: '/loading.gif'
})
Vue.use(VueHtmlToPaper, {
        name: '_blank',
        specs: [
          'fullscreen=yes',
          'titlebar=yes',
          'scrollbars=yes'
        ],
        styles: [
          'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
          'https://unpkg.com/kidlat-css/css/kidlat.css'
        ]
});
Vue.use(VueMaterial);
Vue.use(VeeValidate);
Vue.use(VModal, { dialog: true });
Vue.use(Toasted);
Vue.use(VueRouter);
Vue.use(Antd);
Vue.component('data-table', DataTable);
Vue.component('vue-dropzone', vue2Dropzone)
Vue.use(VueRouter)
Vue.use(MaterialDashboard)
// global library setup
Object.defineProperty(Vue.prototype, '$Chartist', {
    get() {
        return this.$root.Chartist
    }
})
const router = new VueRouter(Routers);

router.beforeEach((to, from, next) => {
    document.title = 'Vocabulary Learning';
    if (to.matched.some((record) => record.meta.requiresAuth === true) &&
        !window.isAuthenticated) {

        return router.push({ name: 'Login' });
    }

    if (to.matched.some((record) => record.meta.requiresAuth === true) && window.isAdmin) {

        return router.push({ name: "AdminDashboard"});
    }

    if (to.matched.some((record) => record.meta.requiresAdmin === true) && !window.isAdmin) {
        if (window.isAuthenticated) {
            return router.push({ path: '/' });
        } else {
            return router.push({ name: 'Login' });
        }
    }
    return next();
});
router.afterEach((to) => {
    Vue.nextTick(() => {
        //document.getElementById('content').scrollTop = 0;
    });
});

Vue.prototype.$isAuthenticated = window.isAuthenticated;
Vue.prototype.$isAdmin = window.isAdmin;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    data: {
        Chartist: Chartist
    }
}).$mount('#app');

export default app;