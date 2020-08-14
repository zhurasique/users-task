require('./bootstrap');

window.Vue = require('vue');

Vue.component('front-page', require('./components/Form.vue').default);

const form = new Vue({
    el: '#form'
})
