<template>
    <div class="content">
        <el-row type="flex" class="title-row">
            <el-col :span="18" :offset="3">
                <h1>GWAS Catelog</h1>
            </el-col>
        </el-row>
        <el-row type="flex">
            <el-col :span="6" :offset="3"><h3>Association</h3></el-col>
        </el-row>
        <el-row type="flex">
            <el-col :span="3" :offset="3">
                <div>
                    <label>SNP </label>
                    <sup><el-tooltip effect="dark" content="SNP most strongly associated with trait + risk/effect allele. This may also be haplotype or SNPxSNP interaction." placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p><a :href="'http://www.ebi.ac.uk/gwas/search?query=' + vdata.snp" target="_blank">{{ vdata.snp_risk }}</a> <a :href="'http://www.ensembl.org/Homo_sapiens/Variation/Summary?v=' + vdata.snp" target="_blank" class="icon_link"><i class="el-icon-search"></i></a></p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>RAF </label>
                    <sup><el-tooltip effect="dark" content="Risk/effect allele frequency in controls" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.risk_freq }}</p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>p-value </label>
                    <sup><el-tooltip effect="dark" content="p-value for most strongly associated SNP, along with any information describing context of p-value" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.pvalue }}</p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>p-value text </label>
                    <sup><el-tooltip effect="dark" content="Information describing context of p-value (e.g. females, smokers)" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.pvalue_text }}</p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>OR or Beta </label>
                    <sup><el-tooltip effect="dark" content="Odds ratio associated with SNP or beta-coefficient and unit increase/decrease associated with SNP" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.or_beta }}</p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>CI </label>
                    <sup><el-tooltip effect="dark" content="95% confidence interval for OR or beta" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.ci95 }}</p>
            </el-col>
        </el-row>
        <el-row type="flex">
            <el-col :span="3" :offset="3">
                <div>
                    <label>Region</label>
                    <sup><el-tooltip effect="dark" content="Cytogenetic region of SNP" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p><a :href="'http://www.ebi.ac.uk/gwas/search?query=' + vdata.region" target="_blank">{{ vdata.region }}</a></p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>Location </label>
                    <sup><el-tooltip effect="dark" content="Chromosome and base pair location of SNP" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.chr }}:{{ vdata.pos }}</p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>Reported gene(s) </label>
                    <sup><el-tooltip effect="dark" content="Gene(s) reported by author" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <div><div v-for="g in formatGenes(vdata.reported_gene)"><a :href="'https://www.ebi.ac.uk/gwas/search?query=' + g" target="_blank">{{ g }}</a></div></div>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>Mapped gene(s) </label>
                    <sup><el-tooltip effect="dark" content="Gene(s) mapped by the Ensembl" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <div><div v-for="g in formatGenes(vdata.mapped_gene)"><a :href="'https://www.ebi.ac.uk/gwas/search?query=' + g" target="_blank">{{ g }}</a></div></div>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>Upstream gene </label>
                    <sup><el-tooltip effect="dark" content="Entrez Gene ID for nearest upstream gene to rs number and distance in kb, if not within gene" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p v-if="vdata.upstream_gene"><a :href="'https://www.ncbi.nlm.nih.gov/gene/?term=' + vdata.upstream_gene" target="_blank">{{ vdata.upstream_gene }}</a>: {{ vdata.upstream_gene_dis }}</p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>Downstream gene </label>
                    <sup><el-tooltip effect="dark" content="Entrez Gene ID for nearest downstream gene to rs number and distance in kb, if not within gene" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p v-if="vdata.upstream_gene"><a :href="'https://www.ncbi.nlm.nih.gov/gene/?term=' + vdata.upstream_gene" target="_blank">{{ vdata.downstream_gene }}</a>: {{ vdata.downstream_gene_dis }}</p>
            </el-col>
        </el-row>
        <el-row type="flex">
            <el-col :span="3" :offset="3">
                <div>
                    <label>Reported trait </label>
                    <sup><el-tooltip effect="dark" content="Gene(s) reported by author" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p><a :href="'https://www.ebi.ac.uk/gwas/search?query=' + vdata.trait" target="_blank">{{ vdata.trait }}</a></p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>Mapped trait </label>
                    <sup><el-tooltip effect="dark" content="Description of disease/trait analysed in the study" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p><a :href="'https://www.ebi.ac.uk/gwas/search?query=' + vdata.mapped_trait" target="_blank">{{ vdata.mapped_trait }}</a></p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>Functional class </label>
                    <sup><el-tooltip effect="dark" content="Functional class of SNP" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.context }}</p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>CNV </label>
                    <sup><el-tooltip effect="dark" content="Study of copy number variation (yes/no)" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.cnv }}</p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>Platform </label>
                    <sup><el-tooltip effect="dark" content="Genotyping platform manufacturer used in Stage 1; also includes notation of pooled DNA study design or imputation of SNPs, where applicable" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.platform }}</p>
            </el-col>
            <el-col :span="3">
                <div>
                    <label>Added date </label>
                    <sup><el-tooltip effect="dark" content="Date a study is published in the catalog" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.added_date }}</p>
            </el-col>
        </el-row>
        <el-row type="flex">
            <el-col :span="6" :offset="3"><h3>Study</h3></el-col>
        </el-row>
        <el-row type="flex">
            <el-col :span="18" :offset="3">
                <p>{{ vdata.study }}</p>
                <p><a :href="'http://www.ebi.ac.uk/gwas/search?query=' + vdata.first_author" target="_blank">{{ vdata.first_author }}</a> (PMID: <a :href="'http://europepmc.org/abstract/MED/' + vdata.pmid" target="_blank">{{ vdata.pmid }}</a>) {{ vdata.journal }} {{ vdata.pub_date }}</p>
            </el-col>
        </el-row>
        <el-row type="flex">
            <el-col :span="9" :offset="3">
                <div>
                    <label>Initial sample </label>
                    <sup><el-tooltip effect="dark" content="Sample size and ancestry description for stage 1 of GWAS (summing across multiple Stage 1 populations, if applicable)" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.initial_sample }}</p>
            </el-col>
            <el-col :span="9">
                <div>
                    <label>Replication sample </label>
                    <sup><el-tooltip effect="dark" content="Sample size and ancestry description for subsequent replication(s) (summing across multiple populations, if applicable)" placement="top-start">
                        <i class="el-icon-warning"></i>
                    </el-tooltip></sup>
                </div>
                <p>{{ vdata.replica_sample }}</p>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        props: ['vdata'],
        methods: {
            formatGenes(genes) {
                if (!genes) {
                    return [];
                }
                let gs = genes.split(',');
                let out = [];
                for (let g of gs) {
                    g = g.replace(/(^\s*)|(\s*$)/g, '');
                    if (g) {
                        out.push(g);
                    }
                }
                return out;
            }
        }
    }
</script>

<style scoped>
    .title-row {
        padding: 0 0 20px 0;
        text-align: center;
    }
    .icon_link {
        text-decoration: none;
        color: #636b6f;
    }
</style>