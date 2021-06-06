/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');
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

Vue.component('default', require('./components/default').default);
Vue.component('menu-add', require('./components/developer/Menu').default);
Vue.component('menu-edit', require('./components/developer/EditMenu').default);
Vue.component('site-setting', require('./components/pages/SiteSetting').default);
Vue.component('admin-profile', require('./components/pages/AdminProfile').default);
Vue.component('user-option', require('./components/pages/UserOption').default);
Vue.component('slider', require('./components/pages/Slider').default);
Vue.component('color', require('./components/pages/Color').default);
Vue.component('unit', require('./components/pages/Unit').default);
Vue.component('size', require('./components/pages/Size').default);
Vue.component('brand', require('./components/pages/Brand').default);
Vue.component('category', require('./components/pages/Category').default);
Vue.component('sub-category', require('./components/pages/SubCategory').default);
Vue.component('sub-sub-category', require('./components/pages/SubSubCategory').default);
Vue.component('product', require('./components/pages/Product').default);
Vue.component('add-list', require('./components/pages/ProductList').default);
Vue.component('orders', require('./components/pages/Orders').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { store } 			from './store';
import { custom } 			from './custom/customJs';
import { alert_message } 	from './custom/alertMessage';
import { selectOption } 	from './custom/selectOption';

const app = new Vue({
    el: '#app',
    store,
    custom,
    alert_message,
    selectOption,
});
