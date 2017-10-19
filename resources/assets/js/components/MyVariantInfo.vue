<template>
    <div class="variant-content" v-if="show_result">
        <div class="variant-result">
            <p>Do you look for</p>
            <el-collapse v-model="activeIndex" accordion>
                <el-collapse-item v-for="(item, index) in results" :title="item._id" :name="index" :key="item._id">
                    <el-collapse>
                        <el-collapse-item v-if="item.dbsnp">
                            <template slot="title">
                                <label>dbSNP: </label> <a :href="'https://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=' + item.dbsnp.rsid" target="_blank">{{ item.dbsnp.rsid }}</a> <i v-if="item.dbsnp.gene">{{ item.dbsnp.gene.symbol }}</i>
                            </template>
                            <div>{{ item.dbsnp.allele_origin }} {{ item.dbsnp.class }} <i class="el-icon-circle-check" v-if="item.dbsnp.validated" title="Validated"></i></div>
                            <div v-if="item.dbsnp.alleles"><span v-for="(k, i) in item.dbsnp.alleles" :key="i">{{ k.allele }}({{ k.freq }}) </span></div>
                        </el-collapse-item>
                        <el-collapse-item v-if="item.clinvar">
                            <template slot="title">
                                <label>ClinVar: </label> <a :href="'https://www.ncbi.nlm.nih.gov/clinvar/variation/' + item.clinvar.variant_id" target="_blank">{{ item.clinvar.rsid }}</a>
                            </template>
                        </el-collapse-item>
                        <el-collapse-item v-if="item.gwassnps">
                            <template slot="title">
                                <label>GWAS: </label> {{ item.gwassnps.trait }}
                            </template>
                            <div>Risk: {{ item.gwassnps.risk_allele }}({{ item.gwassnps.risk_allele_freq }}) pvalue: {{ item.gwassnps.pvalue }}</div>
                            <div><a :href="'https://www.ncbi.nlm.nih.gov/pubmed/?term=' + item.gwassnps.pubmed" target="_blank"><small>{{ item.gwassnps.title }}</small></a></div>
                        </el-collapse-item>
                        <el-collapse-item v-if="item.snpedia">
                            <template slot="title">
                                <label>SNPedia: </label>
                            </template>
                            <div>{{ item.snpedia.text }}</div>
                        </el-collapse-item>
                        <el-collapse-item v-if="item.wellderly">
                            <template slot="title">
                                <label>Scripps Wellderly: </label>
                            </template>
                            <div style="word-break: break-all">{{ item.wellderly.adviser_score }}</div>
                            <div v-if="item.wellderly.alleles"><label>Alleles:</label> <span v-for="(k, i) in item.wellderly.alleles" :key="i">{{ k.allele }}({{ k.freq }}) </span></div>
                            <div v-if="item.wellderly.genotypes"><label>Genotypes:</label> <span v-for="(k, i) in item.wellderly.genotypes" :key="i">{{ k.genotype }}({{ k.freq }}) </span></div>
                        </el-collapse-item>
                        <el-collapse-item v-if="item.exac">
                            <template slot="title">
                                <label>EXAC: </label>
                            </template>
                            <div class="height-limit"><div v-for="(k, i) in item.exac.ac" :key="i">{{ exac_freq(i, k, item.exac.an) }}</div></div>
                        </el-collapse-item>
                    </el-collapse>
                </el-collapse-item>
            </el-collapse>
        </div>
        <div class="credit">From MyVariant.info</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                api: 'http://myvariant.info/v1/query',
                show_result: false,
                total: 0,
                results: [],
                activeIndex: 1
            }
        },
        props: ['query', 'fields'],
        methods: {
            exac_freq(name, ac, an) {
                if (name == 'ac') {
                    if ('an' in an) {
                        return 'All: ' + ac + '/' + an['an'];
                    }
                } else {
                    let race = name.substr(name.indexOf('_') + 1);
                    let k = 'an_' + race;
                    if (k in an) {
                        return race + ': ' + ac + '/' + an[k];
                    }
                }
            }
        },
        created() {
            let fields = this.fields ? this.fields : undefined;
            let params = {q: this.query, fields: fields};
            let instance = axios.create();
            delete instance.defaults.headers.common['X-CSRF-TOKEN'];
            instance.get(this.api, {
                params: params,
                headers: {'X-Requested-With': 'XMLHttpRequest'},
            }).then(function (response) {
                if ('total' in response.data) {
                    this.total = response.data.total;
                    if (this.total > 0) {
                        this.show_result = true;
                    }
                }
                console.log(this.show_result);
                console.log(response.data);
                if ('hits' in response.data) {
                    this.results = response.data.hits;
                }
            }.bind(this)).catch(function (error) {
                console.log(error);
            });
        }
    }
</script>

<style scoped>
    .variant-content {
        background-color: #ffffff;
        padding: 10px;
        border-radius: 5px;
        opacity: 0.6;
    }
    .variant-content:hover {
        opacity: 1;
    }
    .variant-result {
        padding: 0 0 5px 0;
    }
    .height-limit {
        max-height: 180px;
        overflow: auto;
    }
    .credit {
        font-size: 12px;
    }
</style>