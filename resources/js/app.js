require('./bootstrap');

require('./filters');
require('./topic');

import "magnific-popup";

window.Router = require('./router').default

Vue.component('calendar', require('./components/Calendar.vue').default);
Vue.component('journal-entry', require('./components/JournalEntry.vue').default);
Vue.component('day-entry', require('./components/DayEntry.vue').default);
Vue.component('transition-page', require('./components/TransitionPage.vue').default);
Vue.component('selected-topics', require('./components/SelectedTopics.vue').default);
Vue.component('item-text', require('./components/ItemText.vue').default);

new Vue({ router: window.Router, el: '#app' })

