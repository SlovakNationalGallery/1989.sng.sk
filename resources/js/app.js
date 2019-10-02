
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('calendar', require('./components/Calendar.vue').default);


import App from './components/App.vue';
import Vue from 'vue';

export default new Vue({
  render: h => h(App)
});