require('./bootstrap');

window.Vue = require('vue');

// vue router
import VueRouter from 'vue-router'
Vue.use(VueRouter)
const routes = [
    { path: '/home', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '*', component: require('./components/404.vue').default },
  ]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})
// end vue router

//sweet alert 2
import Swal from 'sweetalert2'
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
  });
window.Toast = Toast;
//end sweet alert 2

//filter
import moment from 'moment';

Vue.filter('format_date', function (laravel_date) {
  return moment(laravel_date).format('MMM Do, YYYY');
})

Vue.filter('capitalize', function (text) {
  return text.charAt(0).toUpperCase() + text.slice(1)
})
//end filter


//progress bar
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(30, 150, 242)',
  failedColor: 'red',
  height: '3px'
})
//end progress bar

//vform
import { Form, HasError, AlertError } from 'vform'
window.Form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
//end vform

//event
window.Fire = new Vue();
//end event


//gate

import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);

//end gate

Vue.component('not-found', require('./components/404.vue').default);
Vue.component('passport-clients', require('./components/passport/Clients.vue').default);
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue').default);
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue').default);

const app = new Vue({
    el: '#app',
    router,
    data() {
      return {
        search_terms: ''
      }
    },

    methods: {
      search: _.debounce( () => {
        Fire.$emit("search");
      }, 1000)
    }
});

