<template>
    <el-input placeholder="Search" icon="search" v-model="search_term" :on-icon-click="submit" @keyup.enter.native="submit" autofocus></el-input>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        computed: {
            search_term: {
                get() {
                    return this.$store.state.search_term;
                },
                set(value) {
                    this.$store.commit('search_term', value);
                }
            },
        },
        methods: {
            submit(e) {
//                if (this.txt_input == this.search_term) {
//                    return;
//                }
                this.$emit('submit_search', this.search_term);
            },
        }
    }
</script>

<style scoped>

</style>