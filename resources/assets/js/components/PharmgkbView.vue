<template>
    <div class="content">
        <el-row type="flex" class="title-row">
            <el-col :span="18" :offset="3">
                <h1>Clinical Annotation for {{ vdata.name }} ({{ vdata.levelOfEvidence.term }})</h1>
            </el-col>
        </el-row>
        <el-row type="flex">
            <el-col :span="6" :offset="3">
                <div><label>AccessionId</label></div>
                <p>{{ vdata.accessionId }}</p>
            </el-col>
            <el-col :span="6">
                <div><label>Location</label></div>
                <p>{{ vdata.loci }}</p>
            </el-col>
            <el-col :span="6">
                <div><label>Type</label></div>
                <p>{{ vdata.location.type }}</p>
            </el-col>
        </el-row>
        <el-row type="flex">
            <el-col :span="6" :offset="3">
                <el-row>
                    <div><label>Level of Evidence</label></div>
                    <p>{{ vdata.levelOfEvidence.term }}</p>
                </el-row>
                <el-row>
                    <div><label>Type</label></div>
                    <p>{{ vdata.types.join(', ') }}</p>
                </el-row>
                <el-row>
                    <div><label>Genes</label></div>
                    <p>{{ vdata.gene }}</p>
                </el-row>
                <el-row>
                    <div><label>Variant</label></div>
                    <p>{{ vdata.symbol }}</p>
                </el-row>
                <el-row>
                    <div><label>Drugs</label></div>
                    <div v-for="d in vdata.relatedChemicals">{{ d.name }}</div>
                </el-row>
                <el-row>
                    <div><label>Phenotypes</label></div>
                    <div v-for="d in vdata.relatedDiseases">{{ d.name }}</div>
                </el-row>
                <el-row>
                    <div><label>OMB Race</label></div>
                    <p v-if="vdata.mixedPopulation">Mixed Population</p>
                    <p v-else>{{ vdata.ombRaces.join(', ') }}</p>
                </el-row>
                <el-row>
                    <div><label>Race Notes</label></div>
                    <p>{{ vdata.raceNotes }}</p>
                </el-row>
            </el-col>
            <el-col :span="12">
                <el-row>
                    <el-table :data="vdata.allelePhenotypes">
                        <el-table-column prop="allele" label="Allele" width="100"></el-table-column>
                        <el-table-column prop="phenotype" label="Phenotype"></el-table-column>
                    </el-table>
                </el-row>
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

        }
    }
</script>

<style scoped>
    .title-row {
        padding: 0 0 20px 0;
    }
</style>