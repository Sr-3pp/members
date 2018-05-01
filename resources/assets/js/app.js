
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

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('parallax-bg', require('./components/Parallax.vue'));
Vue.component('miembros', require('./components/Miembros.vue'));
Vue.component('empresa', require('./components/Empresa.vue'));
Vue.component('poplogin', require('./components/Poplogin.vue'));
Vue.component('register', require('./components/Register.vue'));
Vue.component('perfil', require('./components/Perfil.vue'));
Vue.component('programa', require('./components/Programa.vue'));
Vue.component('valoraciones', require('./components/Valoraciones.vue'));


Vue.component('panel', require('./components/panel/Panel.vue'));
Vue.component('inbox', require('./components/panel/partials/Inbox.vue'));
Vue.component('members', require('./components/panel/partials/Members.vue'));
Vue.component('programs', require('./components/panel/partials/Programs.vue'));
Vue.component('general', require('./components/panel/partials/General.vue'));

Vue.component('newprogram', require('./components/panel/modals/NewProgram.vue'));
Vue.component('participants', require('./components/panel/modals/ParticipantsModal.vue'));


Vue.component('navigation', require('./components/partials/Navigation.vue'));
Vue.component('preview', require('./components/partials/PreviewPic.vue'));
Vue.component('modal', require('./components/partials/Modal.vue'));
Vue.component('card', require('./components/partials/Card.vue'));

Vue.prototype.$bus = new Vue();

const app = new Vue({
    el: '#app'
});
