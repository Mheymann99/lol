
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('application', require('./components/Application.vue'));
Vue.component('data-table', require('./components/Table.vue'));

const routes = [
    {
        path: '/',
        component: require('./views/BaseView.vue'),
    },
    {
        path: '/summoner/:summoner',
        component: require('./views/Summoner.vue'),
        props: true
    },
    {
        path: '/summoner/:summoner/champion/:champion/ranked/:ranked',
        component: require('./views/Champion.vue'),
        props: true
    },
    {
        path: '/summoner/:summoner/champion/:champion/opponent/ranked/:ranked',
        component: require('./views/Opponent.vue'),
        props: true
    },
    {
        path: '/matchups/:summoner_id',
        component: require('./views/Matchups.vue'),
        props: true
    },
    {
        path: '/opponent/matchups/:summoner_id',
        component: require('./views/OpponentMatchups.vue'),
        props: true
    },
];

const router = new VueRouter({
    routes, // short for `routes: routes`,
    //no # mode
});

const app = new Vue({
    el: '#app',
    router
});
