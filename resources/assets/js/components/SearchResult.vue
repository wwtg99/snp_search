<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix header">
            <span class="title">
                <span v-if="result._link"><a :href="result._link.link" target="_blank">{{ result._title }}</a></span>
                <span v-else><el-button type="text" @click="show_detail">{{ result._title }}</el-button></span>
                &nbsp;&nbsp;<i class="el-icon-information" @click="show_detail2"></i>
            </span>
            <span class="type" :class="result._type.toLowerCase()">{{ result._label }}</span>
        </div>
        <div class="content" v-html="result._abstract"></div>
    </el-card>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        methods: {
            show_detail() {
                return window.open('/snp/view/' + this.result._index + '/' + this.result._type + '/' + this.result._id);
            },
            show_detail2() {
                const h = this.$createElement;
                let msg = this.parseSource(this.result._source);
                let links = this.parseLinks(this.result._link);
                this.$alert(h('div', null, [
                    h('pre', {'class': 'flow'}, msg),
                    h('ul', null, links)
                ]), this.result._title);
            },
            parseSource(source, indent=0) {
                const h = this.$createElement;
                if (source instanceof Array) {
                    let d = [];
                    let allText = true;
                    for (let i of source) {
                        if (i instanceof Object) {
                            allText = false;
                        }
                        d.push(i);
                    }
                    //join all text array
                    if (allText) {
                        return h('span', null, d.join(', '));
                    } else {
                        //go into object array
                        let dd = [];
                        for (let j of d) {
                            dd.push(this.parseSource(j, indent + 2));
                        }
                        return dd;
                    }
                } else if (source instanceof Object) {
                    let d = [];
                    for (let i in source) {
                        if (i.substr(0, 1) == '@') {
                            continue;
                        }
                        d.push(h('div', null, [
                            h('label', null, ' '.repeat(indent) + i + ': '),
                            this.parseSource(source[i], indent + 2)
                        ]));
                    }
                    return d;
                } else {
                    return h('span', null, source);
                }
            },
            parseLinks(links) {
                const h = this.$createElement;
                if (links && 'name' in links && 'link' in links) {
                    return [h('li', null, [h('a', {'attrs': {'href': links['link'], 'target': '_blank'}}, links['name'])])];
                } else if (links instanceof Array) {
                    let lks = [];
                    for (let i of links) {
                        lks.push(this.parseLinks(i));
                    }
                    return lks;
                } else {
                    return '';
                }
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
        line-height: 1.2em;
        font-size: 14px;
    }
    .flow {
        overflow: auto;
        max-height: 400px;
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
    .deafnessvdb {
        color: #ffffff;
        background: #CC0000;
    }
    .pharmgkb {
        color: #ffffff;
        background: #497de3;
    }
    .gwas_catelog {
        color: #ffffff;
        background: #398a96
    }
</style>