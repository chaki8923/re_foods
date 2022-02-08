require('./bootstrap');
window.Vue = require('vue');

Vue.component('chat-component', require('./components/chat.vue').default);

const app = new Vue({
    el: '#chat',
});