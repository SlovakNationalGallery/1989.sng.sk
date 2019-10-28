window.Vue = require('vue');
window.$ = require('jquery');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.component('calendar', require('./components/Calendar.vue').default);