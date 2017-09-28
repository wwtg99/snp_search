<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix header">
            <span class="title">
                <a v-if="result.link" href="result.link" target="_blank">{{ result.title }}</a>
                <span v-else>{{ result.title }}</span>
            </span>
            <span class="type" :class="result.type.toLowerCase()">{{ result.type }}</span>
        </div>
        <div class="content">{{ result.abstract }}</div>
    </el-card>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        props: ['result'],
    }
</script>

<style scoped>
    .box-card {
        margin-bottom: 20px;
    }
    .header {
        line-height: 0.8em;
    }
    .header .title {
        font-size: 18px;
        font-weight: 600;
    }
    .header .type {
        float: right;
        font-size: 14px;
        border: 1px solid #999999;
        padding: 5px;
        border-radius: 5px;
    }
    .content {
        line-height: 0.6em;
        font-size: 14px;
    }

    /*type class*/
    .dbsnp {
        color: #ffffff;
        background: #2a88bd;
    }
    .ensemble {
        color: #ffffff;
        background: #2b542c;
    }
</style>