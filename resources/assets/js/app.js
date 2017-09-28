import Vuex from 'vuex'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import style from '../css/app.css'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.use(Vuex);
Vue.use(ElementUI);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('searchbox', require('./components/SearchBox.vue'));
Vue.component('search-home', require('./components/SearchHome.vue'));
Vue.component('search-list', require('./components/SearchList.vue'));
Vue.component('search-result', require('./components/SearchResult.vue'));

const store = new Vuex.Store({
    state: {
        search_term: '',
        results: [],
        show_types: []
    },
    mutations: {
        search_term (state, term) {
            state.search_term = term;
        },
        search_results (state, results) {
            state.results = results;
        },
        show_types (state, types) {
            state.show_types = types;
        },
        update_result (state, payload) {
            let index = payload.index;
            let result = payload.result;
            if (index < state.results.length) {
                state.results[index] = result;
            }
        }
    }
});

const app = new Vue({
    el: '#app',
    store
});
