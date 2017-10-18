<template>
    <el-input placeholder="Search" icon="search" v-model="txt_input" :on-icon-click="submit" @keyup.enter.native="submit" autofocus></el-input>
</template>

<script>
    export default {
        data() {
            return {
                txt_input: ''
            }
        },
        computed: {
            search_term() {
                return this.$store.state.search_term;
            },
        },
        methods: {
            submit(e) {
//                if (this.txt_input == this.search_term) {
//                    return;
//                }
                this.$store.commit('search_term', this.txt_input);
                this.$emit('submit_search', this.txt_input);
            },
        }
    }
</script>

<style scoped>

</style>