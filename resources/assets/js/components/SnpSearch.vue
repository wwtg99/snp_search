<template>
    <div class="content">
        <div class="bgpic">
            <img src="../../image/bg1.jpg">
            <div class="header_wrapper">
                <h1>SNP Search</h1>
            </div>
        </div>
        <el-row type="flex" justify="center" class="search-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12" class="search-wrapper">
                <el-input placeholder="Search" icon="search" v-model="search_term" :on-icon-click="search" @keyup.enter.native="search()" autofocus></el-input>
            </el-col>
        </el-row>
        <el-row type="flex" justify="center" class="example-row" v-if="databases">
            <el-col :xs="22" :sm="20" :md="16" :lg="12">
                <el-select v-model="database" placeholder="Select Database">
                    <el-option key="all" label="All" value="0">All</el-option>
                    <el-option v-for="item in databases" :key="item.key" :value="item.key" :label="item.label">{{ item.label }}</el-option>
                </el-select>
            </el-col>
        </el-row>
        <el-row type="flex" justify="start" class="example-row">
            <el-col :xs="{'span': 12, 'offset': 1}" :sm="{'span': 12, 'offset': 2}" :md="{'span': 6, 'offset': 4}" :lg="{'span': 6, 'offset': 6}">
                <p>Example: <el-button type="text" @click="example()">rs7412</el-button></p>
            </el-col>
            <el-col :xs="10" :sm="8" :md="8" :lg="6">
                <p><el-button type="text" @click="redirect('/snp/freq')">SNP Frequency</el-button></p>
            </el-col>
        </el-row>
        <el-row type="flex" justify="center" v-if="error" class="error-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12">
                <el-alert :title="error" type="error" :closable="false"></el-alert>
            </el-col>
        </el-row>
        <el-row type="flex" justify="center" v-if="loading" class="loading-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12">
                <i class="el-icon-loading"></i>
            </el-col>
        </el-row>
        <el-row type="flex" justify="center" v-if="show_result" class="result-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12">
                <search-list></search-list>
            </el-col>
        </el-row>
        <el-row type="flex" justify="center" v-if="show_result" class="pagination-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12">
                <div class="center">
                    <el-pagination small layout="prev, pager, next" :page-count="meta.last_page" :current-page.sync="meta.current_page" @current-change="changePage"></el-pagination>
                </div>
            </el-col>
        </el-row>
        <div class="variant" v-if="show_result">
            <my-variant-info :query="search_term" :fields="'dbsnp,gwassnps,snpedia,clinvar,wellderly,exac'"></my-variant-info>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                error: '',
                show_result: false,
                loading: false,
                databases: [],
                database: ''
            }
        },
        computed: {
            results() {
                return this.$store.state.results
            },
            meta() {
                return this.$store.state.meta
            },
            search_term: {
                get() {
                    return this.$store.state.search_term;
                },
                set(value) {
                    this.$store.commit('search_term', value);
                }
            }
        },
        methods: {
            search(term = null, page = 1) {
                if (!term || typeof(term) != 'string') {
                    term = this.search_term;
                }
                this.error = '';
                this.loading = true;
                this.show_result = false;
                let database = this.database ? this.database : undefined;
                axios.get('/api/snp/search', {
                    params: {
                        term: term,
                        page: page,
                        database: database
                    }
                }).then(function (response) {
                    if (response.data) {
                        if ('error' in response.data) {
                            this.error = response.data.error;
                        } else {
                            this.$store.commit('search_results', response.data.data);
                            this.$store.commit('search_meta', response.data.meta);
                            this.show_result = true;
                        }
                    }
                    this.loading = false;
                }.bind(this)).catch(function (error) {
                    this.error = 'Server Error!';
                    this.loading = false;
                }.bind(this));
            },
            changePage(currentPage) {
                this.search(this.search_term, currentPage);
            },
            example() {
                this.search_term = 'rs7412';
                this.search();
            },
            redirect(url) {
                window.location.href = url;
            },
            getDatabases()
            {
                axios.get('/api/snp/databases').then(function (response) {
                    if (response.data) {
                        this.databases = response.data;
                    }
                }.bind(this)).catch(function (error) {

                }.bind(this));
            }
        },
        created() {
            this.getDatabases();
        }
    }
</script>

<style scoped>
    .content {
        min-height: 500px;
    }
    .bgpic {
        width: 100%;
    }
    .bgpic img {
        width: 100%;
    }
    .bgpic .header_wrapper {
        position: absolute;
        top: 50px;
        width: 100%;
        text-align: center;
        margin: 0 auto;
    }
    .bgpic .header_wrapper h1 {
        color: #f9f9f9;
        font-size: 4rem;
        margin-bottom: 20px;
    }
    .search-row {
        position: relative;
        top: -30px;
    }
    .search-wrapper {
        padding: 15px;
        border-radius: 5px;
        background-color: rgba(100, 100, 100, 0.5);
    }
    .example-row {
        padding: 0;
    }
    .error-row {
        padding: 20px 0;
    }
    .loading-row {
        padding: 20px 0;
    }
    .result-row {
        padding: 20px 0;
    }
    .pagination-row {
        padding: 20px 0;
    }
    .center {
        text-align: center;
        margin: 0 auto;
    }
    .variant {
        position: fixed;
        top: 100px;
        right: 10px;
        width: 250px;
        z-index: 1000;
        overflow: auto;
    }
</style>