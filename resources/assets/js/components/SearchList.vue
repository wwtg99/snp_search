<template>
    <div>
        <label class="count">Total：{{ count }}</label>
        <div v-if="count == 0" class="empty"><p>No results matched your query.</p></div>
        <div class="filter">
            <label>Filter by Type</label>
            <el-checkbox-group v-model="show_types">
                <el-checkbox v-for="(t, index) in all_types" :label="index" :key="index">{{ t }}</el-checkbox>
            </el-checkbox-group>
        </div>
        <search-result v-if="r.visibility !== false" v-for="r in results" :key="r._id" :result="r"></search-result>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                all_types: {},
                show_types: []
            }
        },
        computed: {
            results() {
                return this.$store.state.results;
            },
            count() {
                return this.$store.state.meta.total;
            }
        },
        watch: {
            results(newResults) {
                this.show_types = this.getAllTypes();
            },
            show_types(newShowTypes) {
                this.changeVisibility(newShowTypes);
            }
        },
        methods: {
            getAllTypes() {
                let types = {};
                let tpSet = new Set();
                for (let r of this.results) {
                    types[r._type] = r._label;
                    tpSet.add(r._type);
                }
                this.all_types = types;
                return new Array(...tpSet);
            },
            changeVisibility(showTypes) {
                for (let i = 0; i < this.results.length; i++) {
                    let res = this.results[i];
                    let t = res._type;
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
            this.show_types = this.getAllTypes();
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