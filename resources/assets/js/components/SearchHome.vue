<template>
    <div class="content">
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
        <el-row type="flex" justify="center" v-if="show_result" class="result-row">
            <el-col :xs="22" :sm="20" :md="16" :lg="12">
                <search-list></search-list>
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
            results() {
                return this.$store.state.results
            }
        },
        methods: {
            search(term) {
                this.error = '';
                axios.get('/api/search', {
                    params: {
                        term: term
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
                }.bind(this)).catch(function (error) {
                    this.error = error;
                });
            }
        }
    }
</script>

<style scoped>
    .content {
        min-height: 500px;
    }
    .search-row {
        padding: 20px 0;
    }
    .error-row {
        padding: 20px 0;
    }
    .result-row {
        padding: 20px 0;
    }
</style>