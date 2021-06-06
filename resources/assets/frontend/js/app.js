/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue   = require('vue');
window.axios = require('axios');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('master', require('./components/Master').default);
Vue.component('category', require('./components/Category').default);
Vue.component('product-home', require('./components/ProductHome').default);
Vue.component('shop', require('./components/Shop').default);
Vue.component('user-login', require('./components/Login').default);
Vue.component('user-menu', require('./components/cpanel/UserMenu').default);
Vue.component('user-panel', require('./components/cpanel/Layout').default);
Vue.component('user-notification', require('./components/UserNotification').default);
Vue.component('cart', require('./components/Cart').default);
Vue.component('order-details', require('./components/OrderDetails').default);
Vue.component('search', require('./components/Search').default);
Vue.component('search', require('./components/Search').default);
Vue.component('select-picker', require('./components/Select').default);
Vue.component('options', require('./components/Option').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { store }  from './store';
import { helper }  from './custom/helper';
import { alert_message } 	from './custom/alertMessage';

const app = new Vue({
    el: '#app',
    store,
    helper,
    alert_message,
});
