require('./bootstrap');

window.Vue = require('vue');
import Hello from './components/Hello';

const app = new Vue({
    el: '#app',
    render: h => h(Hello)
});
