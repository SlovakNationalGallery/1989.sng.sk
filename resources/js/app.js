require('./bootstrap');

require('./filters');
window.Router = require('./router').default

Vue.component('calendar', require('./components/Calendar.vue').default);
Vue.component('journal-entry', require('./components/JournalEntry.vue').default);
