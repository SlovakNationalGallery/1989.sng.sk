require('./bootstrap');

require('./filters');
window.Router = require('./router').default

Vue.component('calendar', require('./components/Calendar.vue').default);
Vue.component('journal-entry', require('./components/JournalEntry.vue').default);
Vue.component('day-entry', require('./components/DayEntry.vue').default);
Vue.component('transition-page', require('./components/TransitionPage.vue').default);

new Vue({ router: window.Router, el: '#app' })
