<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix header">
            <span class="title">{{ variant }}</span>
            <span class="maf">MAF: {{ result.MAF }}</span>
        </div>
        <div class="content">
            <p v-if="result.mappings"><label>Location: </label> {{ result.mappings[0].location }} {{ result.mappings[0].allele_string }}</p>
            <div class="freqs" v-if="pops">
                <el-collapse>
                  <el-collapse-item v-for="(pop, cate) in pops" :key="cate" :title="cate" :name="cate">
                    <el-row v-for="(item, p) in pop" :key="p">
                        <el-col :xs="24" :sm="15" :md="15" :lg="15">
                            <p>{{ p }}</p>
                            <div v-if="item.length > 1">{{ item[0]['allele'] }}({{ item[0]['allele_count'] }}) / {{ item[1]['allele'] }}({{ item[1]['allele_count'] }})</div>
                            <div v-else>{{ item[0]['allele'] }}({{ item[0]['allele_count'] }})</div>
                        </el-col>
                        <el-col :xs="24" :sm="9" :md="9" :lg="9">
                            <div class="charts" :id="getChartId(cate, p)"></div>
                        </el-col>
                    </el-row>
                  </el-collapse-item>
                </el-collapse>
            </div>
        </div>
    </el-card>
</template>

<script>
    export default {
        data() {
            return {
                pops: {}
            }
        },
        computed: {
            
        },
        methods: {
            parsePopulations() {
                for (let p of this.result.populations) {
                    let cate = p.population.substr(0, p.population.indexOf(':'));
                    let popu = p.population.substr(p.population.indexOf(':') + 1);
                    if (cate in this.pops) {
                        if (popu in this.pops[cate]) {
                            this.pops[cate][popu].push(p);
                        } else {
                            this.pops[cate][popu] = [p];
                        }
                    } else {
                        this.pops[cate] = {};
                        this.pops[cate][popu] = [p];
                    }
                }
            },
            getChartId(category, pop) {
                return [this.variant, category, pop].join(':');
            },
            getOption(category, pop) {
                let d = this.pops[category][pop];
                let xdata = [];
                let legend = [];
                for (let item of d) {
                    xdata.push({value: item['allele_count'], name: item['allele']});
                    legend.push(item['allele']);
                }
                return {
                    tooltip: {
                        trigger: 'item',
                        formatter: "{b}: {c} ({d}%)"
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        data: legend
                    },
                    series: [
                        {
                            name: pop,
                            type: 'pie',
                            radius: ['50%', '70%'],
                            avoidLabelOverlap: false,
                            label: {
                                normal: {
                                    show: false,
                                    position: 'center'
                                },
                                emphasis: {
                                    show: true,
                                    textStyle: {
                                        fontSize: '30',
                                        fontWeight: 'bold'
                                    }
                                }
                            },
                            labelLine: {
                                normal: {
                                    show: false
                                }
                            },
                            data: xdata
                        }
                    ]
                };
            }
        },
        props: ['variant', 'result'],
        created() {
            this.parsePopulations();
            console.log(this.result);
        },
        mounted() {
            //init echarts
            for (let cate in this.pops) {
                for (let pop in this.pops[cate]) {
                    let myChart = this.$echarts.init(document.getElementById(this.getChartId(cate, pop)));
                    let option = this.getOption(cate, pop);
                    myChart.setOption(option);
                }
            }
        }
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
    .header .maf {
        float: right;
        font-size: 16px;
    }
    .content {
        line-height: 1.2em;
        font-size: 14px;
    }
    .charts {
        width: 200px;
        height: 150px;
    }
</style>