<template>
    <v-container fluid class="pa-0">
        <v-row>
            <v-col cols="12" class="d-flex justify-start align-center">
                <h2 class="text-h6 font-weight-bold text-uppercase">Statystyki</h2>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="4">
                <v-row>
                    <v-col cols="6">
                        <questionnaires-statistic-count
                            :number-of-questionnaires="5"
                        ></questionnaires-statistic-count>
                    </v-col>
                    <v-col cols="6">
                        <questionnaires-statistic-count
                            :number-of-questionnaires="5"
                        ></questionnaires-statistic-count>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="6">
                        <questionnaires-statistic-count
                            :number-of-questionnaires="5"
                        ></questionnaires-statistic-count>
                    </v-col>
                    <v-col cols="6">
                        <questionnaires-statistic-count
                            :number-of-questionnaires="5"
                        ></questionnaires-statistic-count>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="4">
                <custom-card>
                    <v-container fluid>
                        <v-sparkline
                            color="primary"
                            :line-width="2"
                            :labels="['a','b','c','d','e','z']"
                            smooth
                            :value="[2,5,1,2,10,4]"
                        ></v-sparkline>
                    </v-container>
                </custom-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" class="d-flex justify-start align-center">
                <h2 class="text-h6 font-weight-bold text-uppercase">Ankiety</h2>
            </v-col>
        </v-row>
        <v-row class="mt-7">
            <v-col cols="12">
                <questionnaires-list :questionnaires="questionnaires"></questionnaires-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions} from "vuex";
import QuestionnairesList from "../../Questionnaires/QuestionnairesList";
import QuestionnairesStatisticCount from "../../Questionnaires/QuestionnairesStatisticCount";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheCompanyQuestionnaires",
    components: {CustomCardTitle, CustomCard, QuestionnairesStatisticCount, QuestionnairesList},

    data() {
        return {
            questionnaires: [
                {
                    id: 1,
                    name: 'Ankieta na zakończenie praktyki',
                    description: 'testowy'
                },
                {
                    id: 2,
                    name: 'Test 2',
                    description: 'testowy 2'
                }
            ]
        }
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Firma', to: {name: 'company', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Ankiety', to: {name: 'company-questionnaires'}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
