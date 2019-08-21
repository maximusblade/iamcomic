require('./bootstrap');


window.Vue = require('vue');



Vue.component('crawler', require('./components/Crawler.vue').default);


const app = new Vue({
    
    el: '#crawler-app',

});

