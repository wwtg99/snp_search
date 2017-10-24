<template>
    <div class="content">
        <el-row type="flex" justify="center" class="search-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12">
                <img src="../../image/logo.png" class="logo">
            </el-col>
        </el-row>
        <el-row type="flex" justify="center" class="search-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12">
                <h1 class="page-header center">SNP Frequency</h1>
                <searchbox @submit_search="search"></searchbox>
                <p>Get frequency of SNPs (comma or space to separate). Example: <el-button type="text" @click="example()">rs7412</el-button></p>
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
                <div v-if="kgfreq_results.length == 0" class="empty"><p>No results matched your query.</p></div>
                <kgfreq-result v-for="(item, name) in kgfreq_results" :key="name" :variant="name" :result="item"></kgfreq-result>
            </el-col>
        </el-row>
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
            kgfreq_results() {
                return this.$store.state.kgfreq_results
            },
            search_term() {
                return this.$store.state.search_term;
            }
        },
        methods: {
            search(term) {
                this.error = '';
                this.loading = true;
                this.show_result = false;
                axios.post('/api/kgfreq', {
                    ids: term
                }).then(function (response) {
                    if (response.data) {
                        if ('error' in response.data) {
                            this.error = response.data.error;
                        } else {
                            this.$store.commit('kgfreq_results', response.data);
                            this.show_result = true;
                        }
                    }
                    this.loading = false;
                }.bind(this)).catch(function (error) {
                    this.error = error;
                });
            },
            example() {
                let t = 'rs7412';
                this.$store.commit('search_term', t);
                this.search(t);
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
    .empty {
        color: #9FA6B5;
        text-align: center;
        font-size: 20px;
        font-weight: 300;
    }
    .center {
        text-align: center;
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