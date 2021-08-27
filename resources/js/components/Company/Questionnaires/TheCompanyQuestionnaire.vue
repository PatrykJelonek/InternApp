<template>
    <v-container fluid class="pa-0">
        <template v-if="!isQuestionnaireLoading">
            <create-questionnaire-dialog
                :original-name="questionnaire.name"
                :original-description="questionnaire.description"
                :original-id="questionnaire.id"
            ></create-questionnaire-dialog>

            <page-title>
                <template v-slot:default> {{ questionnaire.name }}</template>
                <template v-slot:subheader>{{ questionnaire.description }}</template>
                <template v-slot:actions>
                    <v-btn outlined color="primary" @click="toggleCreateQuestionnaireDialog(true)">Edytuj Ankietę
                    </v-btn>
                </template>
            </page-title>
            <v-row>
                <v-col cols="12" lg="6">
                    <expand-card
                        title="Pytania"
                        :description="'Lista pytań dla ankiety ' + questionnaire.name"
                    >
                        <v-row class="pa-5">
                            <v-col cols="12">
                                <questionnaire-questions-list
                                    :original-questions="this.questionnaire.questions"
                                    :questionnaire-id="this.questionnaire.id"
                                ></questionnaire-questions-list>
                            </v-col>
                        </v-row>
                    </expand-card>
                </v-col>
                <v-col cols="12" lg="6">
                    <questionnaire-answers-list></questionnaire-answers-list>
                </v-col>
            </v-row>
        </template>
        <template v-else>
            <page-loader></page-loader>
        </template>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";
import QuestionnairesListItem from "../../Questionnaires/QuestionnairesListItem";
import QuestionnaireQuestionsList from "../../Questionnaire/QuestionnaireQuestionsList";
import PageLoader from "../../_General/PageLoader";
import PageTitle from "../../_Helpers/PageTitle";
import PageDetailsHeader from "../../Page/PageDetailsHeader";
import CustomCard from "../../_General/CustomCard";
import QuestionnaireAnswersList from "../../Questionnaire/QuestionnaireAnswersList";
import CreateQuestionnaireDialog from "../../Questionnaires/CreateQuestionnaireDialog";

export default {
    name: "TheCompanyQuestionnaire",
    components: {
        CreateQuestionnaireDialog,
        QuestionnaireAnswersList,
        CustomCard,
        PageDetailsHeader,
        PageTitle, PageLoader, QuestionnaireQuestionsList, QuestionnairesListItem, ExpandCard
    },
    computed: {
        ...mapGetters({
            questionnaire: 'questionnaire/questionnaire',
            isQuestionnaireLoading: 'questionnaire/isQuestionnaireLoading',
        }),
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            fetchQuestionnaire: 'questionnaire/fetchQuestionnaire',
            toggleCreateQuestionnaireDialog: 'helpers/toggleCreateQuestionnaireDialog',
        }),
    },

    created() {
        this.fetchQuestionnaire(this.$route.params.questionnaireId).then(() => {
            this.setBreadcrumbs([
                {text: 'Panel', to: {name: 'panel'}, exact: true},
                {text: 'Ankiety', exact: true},
                {
                    text: this.questionnaire.name,
                    to: {
                        name: 'edit-questionnaire',
                        params: {slug: this.$route.params.slug, questionnaireId: this.$route.params.questionnaireId}
                    },
                    exact: true
                },
            ]);
        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
