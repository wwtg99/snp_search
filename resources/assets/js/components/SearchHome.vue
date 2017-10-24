<template>
    <div class="content">
        <el-row type="flex" justify="center" class="search-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12">
                <img src="../../image/logo.png" class="logo">
            </el-col>
        </el-row>
        <el-row type="flex" justify="center" class="search-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12">
                <searchbox @submit_search="search"></searchbox>
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
                loading: false
            }
        },
        computed: {
            results() {
                return this.$store.state.results
            },
            meta() {
                return this.$store.state.meta
            },
            search_term() {
                return this.$store.state.search_term;
            }
        },
        methods: {
            search(term, page = 1) {
                this.error = '';
                this.loading = true;
                this.show_result = false;
                axios.get('/api/snp/search', {
                    params: {
                        term: term,
                        page: page
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
            }
        }
    }
</script>

<style scoped>
    .content {
        min-height: 500px;
    }
    .logo {
        width: 100%;
    }
    .search-row {
        padding: 20px 0;
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