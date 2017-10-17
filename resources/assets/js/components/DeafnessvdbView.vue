<template>
    <div class="content">
        <el-row class="title-row">
            <el-col :span="18" :offset="3">
                <h1>{{ vdata.dbsnp }} ({{ vdata.gene }})</h1>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="9" :offset="3">
                <div><label>Variation</label></div>
                <p>{{ vdata.variation }}</p>
            </el-col>
            <el-col :span="9">
                <div><label>Gene</label></div>
                <p>{{ vdata.gene }}</p>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="9" :offset="3">
                <div><label>HGVS Nucleotide Change</label></div>
                <p>{{ vdata.hgvs_nucleotide_change }}</p>
            </el-col>
            <el-col :span="9">
                <div><label>Variantlocale</label></div>
                <p>{{ vdata.variantlocale }}</p>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="9" :offset="3">
                <div><label>Pathogenicity</label></div>
                <p>{{ vdata.pathogenicity }}</p>
            </el-col>
            <el-col :span="9">
                <div><label>comments</label></div>
                <p>{{ vdata.comments }}</p>
            </el-col>
        </el-row>
        <div class="block" v-if="vdata.sift_pred">
            <el-row>
                <el-col :span="6" :offset="3">
                    <p class="title">IN SILICO COMPUTATIONAL</p>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="18" :offset="3">
                    <table width="100%">
                        <thead>
                        <tr>
                            <th>SIFT</th>
                            <th>Polyphen-2</th>
                            <th>LRT</th>
                            <th>MutationTaster</th>
                            <th>PhyloP</th>
                            <th>GERP++</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ vdata.sift_pred }}</td>
                            <td>{{ vdata.polyphen2_pred }}</td>
                            <td>{{ vdata.lrt_pred }}</td>
                            <td>{{ vdata.mutationtaster_pred }}</td>
                            <td>{{ vdata.phylop_pred }}</td>
                            <td>{{ vdata.gerp_pred }}</td>
                        </tr>
                        <tr>
                            <td>{{ vdata.sift_score }}</td>
                            <td>{{ vdata.polyphen2_score }}</td>
                            <td>{{ vdata.lrt_score }}</td>
                            <td>{{ vdata.mutationtaster_score }}</td>
                            <td>{{ vdata.phylop_score }}</td>
                            <td>{{ vdata.gerp_rs }}</td>
                        </tr>
                        </tbody>
                    </table>
                </el-col>
            </el-row>
        </div>
        <div class="block">
            <el-row>
                <el-col :span="6" :offset="3">
                    <p class="title">VARIANT FREQUENCIES</p>
                </el-col>
            </el-row>
        </div>
        <div v-if="vdata.evs_all_af" class="block">
            <el-row>
                <el-col :span="6" :offset="3">
                    <label class="freq_class">Exome Variant Server</label>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="6" :offset="3" class="freq_block">
                    <label>European-American</label> {{ vdata.evs_ea_ac }} / {{ vdata.evs_ea_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.evs_ea_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>African-American</label> {{ vdata.evs_aa_ac }} / {{ vdata.evs_aa_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.evs_aa_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>All populations</label> {{ vdata.evs_all_ac }} / {{ vdata.evs_all_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.evs_all_af)"></el-progress>
                </el-col>
            </el-row>
        </div>
        <div v-if="vdata.tg_all_af" class="block">
            <el-row>
                <el-col :span="6" :offset="3">
                    <label class="freq_class">1000 Genomes</label>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="6" :offset="3" class="freq_block">
                    <label>African</label> {{ vdata.tg_afr_ac }} / {{ vdata.tg_afr_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.tg_afr_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>American</label> {{ vdata.tg_amr_ac }} / {{ vdata.tg_amr_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.tg_amr_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>European</label> {{ vdata.tg_eur_ac }} / {{ vdata.tg_eur_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.tg_eur_af)"></el-progress>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="6" :offset="3" class="freq_block">
                    <label>East Asian</label> {{ vdata.tg_eas_ac }} / {{ vdata.tg_eas_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.tg_eas_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>South Asian</label> {{ vdata.tg_sas_ac }} / {{ vdata.tg_sas_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.tg_sas_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>All populations</label> {{ vdata.tg_all_ac }} / {{ vdata.tg_all_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.tg_all_af)"></el-progress>
                </el-col>
            </el-row>
        </div>
        <div v-if="vdata.exac_all_af" class="block">
            <el-row>
                <el-col :span="6" :offset="3">
                    <label class="freq_class">ExAC</label>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="6" :offset="3" class="freq_block">
                    <label>African</label> {{ vdata.exac_afr_ac }} / {{ vdata.exac_afr_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.exac_afr_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>American (Latino)</label> {{ vdata.exac_amr_ac }} / {{ vdata.exac_amr_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.exac_amr_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>European (Finnish)</label> {{ vdata.exac_fin_ac }} / {{ vdata.exac_fin_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.exac_fin_af)"></el-progress>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="6" :offset="3" class="freq_block">
                    <label>European (non-Finnish)</label> {{ vdata.exac_nfe_ac }} / {{ vdata.exac_nfe_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.exac_nfe_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>East Asian</label> {{ vdata.exac_eas_ac }} / {{ vdata.exac_eas_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.exac_eas_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>South Asian</label> {{ vdata.exac_sas_ac }} / {{ vdata.exac_sas_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.exac_sas_af)"></el-progress>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="6" :offset="3" class="freq_block">
                    <label>Other</label> {{ vdata.exac_oth_ac }} / {{ vdata.exac_oth_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.exac_oth_af)"></el-progress>
                </el-col>
                <el-col :span="6" class="freq_block">
                    <label>All populations</label> {{ vdata.exac_all_ac }} / {{ vdata.exac_all_an }}
                    <el-progress :text-inside="true" :stroke-width="18" :percentage="Number(vdata.exac_all_af)"></el-progress>
                </el-col>
            </el-row>
        </div>
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

        },
        created() {
            console.log(this.vdata);
        }
    }
</script>

<style scoped>
    .title-row {
        padding: 0 0 20px 0;
    }
    .freq_class {
        padding: 0 0 10px 0;
        color: #999999;
    }
    .block {
        padding: 10px 0;
    }
    .block .title {
        font-weight: bold;
        font-size: 16px;
        padding-top: 10px;
    }
    .freq_group {
        padding: 15px 0 0 0;
    }
    .freq_block {
        padding: 0 5px;
    }
</style>