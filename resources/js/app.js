import VueRouter from 'vue-router'
import Vue from 'vue'
import axios from 'axios'

import router from './router'

window.Vue = Vue
window.Router = router
window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.use(VueRouter)

Vue.component('calendar', require('./components/Calendar.vue').default);
Vue.component('journal-entry', require('./components/JournalEntry.vue').default);
