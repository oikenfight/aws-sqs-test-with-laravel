
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Test App
Vue.component('sqs-test-component', require('./components/SqsTestComponent.vue'));
const app = new Vue({
    el: '#app',
});

// Demo App
Vue.component('demo-app-component', require('./components/Demo/Index'));
const demoApp = new Vue({
    el: '#demo-app',
});
