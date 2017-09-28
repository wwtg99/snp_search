<template>
    <div>
        <label class="count">总数：{{ count }}</label>
        <div v-if="results.length == 0" class="empty"><p>No results matched your query.</p></div>
        <div class="filter">
            <label>Filter by Type</label>
            <el-checkbox-group v-model="show_types">
                <el-checkbox v-for="(t, index) in all_types" :label="t" :key="index"></el-checkbox>
            </el-checkbox-group>
        </div>
        <search-result v-if="r.visibility" v-for="r in results" :key="r.id" :result="r"></search-result>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                all_types: [],
                show_types: []
            }
        },
        computed: {
            results() {
                return this.$store.state.results
            },
            count() {
                return this.results.length
            }
        },
        watch: {
            results(newResults) {
                this.show_types = new Array(...this.getAllTypes());
            },
            show_types(newShowTypes) {
                this.changeVisibility(newShowTypes);
            }
        },
        methods: {
            getAllTypes() {
                let types = new Set();
                for (let r of this.results) {
                    types.add(r.type);
                }
                this.all_types = new Array(...types);
                return this.all_types;
            },
            changeVisibility(showTypes) {
                for (let i = 0; i < this.results.length; i++) {
                    let res = this.results[i];
                    let t = res.type;
                    if (t && showTypes.indexOf(t) >= 0) {
                        res['visibility'] = true;
                    } else {
                        res['visibility'] = false;
                    }
                    this.$store.commit('update_result', {index: i, result: res});
                }
            }
        },
        created() {
            this.show_types = new Array(...this.getAllTypes());
        }
    }
</script>

<style scoped>
    .empty {
        color: #9FA6B5;
        text-align: center;
        font-size: 20px;
        font-weight: 300;
    }
    .filter {
        padding: 0 0 10px 0;
    }
</style>