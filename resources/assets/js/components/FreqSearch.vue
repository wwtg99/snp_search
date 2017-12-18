<template>
    <div class="content">
        <div class="bgpic">
            <img src="/assets/snp/images/bg.jpg">
            <div class="header_wrapper">
                <h1>SNP Frequency</h1>
            </div>
        </div>
        <el-row type="flex" justify="center" class="search-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12" class="search-wrapper">
                <el-input placeholder="Search Frequency" icon="search" v-model="search_term" :on-icon-click="search" @keyup.enter.native="search()" autofocus></el-input>
            </el-col>
        </el-row>
        <el-row type="flex" justify="start" class="example-row">
            <el-col :xs="{'span': 12, 'offset': 1}" :sm="{'span': 14, 'offset': 2}" :md="{'span': 10, 'offset': 4}" :lg="{'span': 10, 'offset': 6}">
                <p>Get frequency of SNPs (comma or space to separate). Example: <el-button type="text" @click="example()">rs7412</el-button></p>
            </el-col>
            <el-col :xs="10" :sm="6" :md="6" :lg="6">
                <p><el-button type="text" @click="redirect('/snp/search')">SNP Search</el-button></p>
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
            search(term = null) {
                if (!term) {
                    term = this.search_term;
                }
                this.error = '';
                this.loading = true;
                this.show_result = false;
                axios.post('/api/snp/freq', {
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
                    this.error = 'Server Error!';
                    this.loading = false;
                }.bind(this));
            },
            example() {
                this.search_term = 'rs7412';
                this.search();
            },
            redirect(url) {
                window.location.href = url;
            }
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
    .empty {
        color: #9FA6B5;
        text-align: center;
        font-size: 20px;
        font-weight: 300;
    }
</style>