import Vuex from 'vuex'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import echarts from 'echarts'
import style from '../css/app.css'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.$echarts = echarts;

Vue.use(Vuex);
Vue.use(ElementUI);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
Vue.component('searchbox', require('./components/SearchBox.vue'));
// Vue.component('search-home', require('./components/SearchHome.vue'));
Vue.component('snp-search', require('./components/SnpSearch.vue'));
Vue.component('search-list', require('./components/SearchList.vue'));
Vue.component('search-result', require('./components/SearchResult.vue'));
Vue.component('pharmgkb-view', require('./components/PharmgkbView.vue'));
Vue.component('deafnessvdb-view', require('./components/DeafnessvdbView.vue'));
Vue.component('gwas-catelog-view', require('./components/GwasCatelogView.vue'));

Vue.component('my-variant-info', require('./components/MyVariantInfo.vue'));
Vue.component('kgfreq', require('./components/KgFreq.vue'));
Vue.component('freq-search', require('./components/FreqSearch.vue'));
Vue.component('kgfreq-result', require('./components/KgFreqResult.vue'));

const store = new Vuex.Store({
    state: {
        search_term: '',
        results: [],
        meta: [],
        show_types: [],
        kgfreq_results: {}
    },
    mutations: {
        search_term (state, term) {
            state.search_term = term;
        },
        search_results (state, results) {
            state.results = results;
        },
        search_meta (state, meta) {
            state.meta = meta;
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
        },
        kgfreq_results (state, results) {
            state.kgfreq_results = results;
        }
    }
});

const app = new Vue({
    el: '#app',
    store
});
