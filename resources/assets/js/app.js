
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.authorize = function(handler) {
	let user = window.App.user;

	return user ? handler(user) : false;
}
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('order-form', require("./components/Order.vue"));
Vue.component('cart', require("./components/Cart.vue"));
Vue.component('chefs', require("./components/Chefs.vue"));
Vue.component('foods', require("./components/Foods.vue"));
const VueGoogleMaps = require('vue2-google-maps');

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAYuOwRKxnJeUnA8HaDZSftXhUfV185QSY',
    libraries: 'places'
  }
});

const app = new Vue({
    el: '#app'
});
