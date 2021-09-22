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
                    <v-btn
                        outlined
                        color="primary"
                        @click="toggleCreateQuestionnaireDialog(true)"
                        v-if="hasUniversityRole(['deanery_worker','university_owner']) || questionnaire.user_id === user.id"
                    >
                        Edytuj Ankietę
                    </v-btn>
                </template>
            </page-title>
            <v-row>
                <v-col cols="12" lg="6">
                    <custom-card :loading="isQuestionnaireQuestionsLoading">
                        <custom-card-title>
                            <template v-slot:default>Pytania</template>
                            <template v-slot:subheader>Lista pytań dla ankiety {{ questionnaire.name }}</template>
                        </custom-card-title>

                        <v-row class="pa-5">
                            <v-col cols="12">
                                <questionnaire-questions-list
                                    :original-questions="this.questionnaire.questions"
                                    :questionnaire-id="this.questionnaire.id"
                                ></questionnaire-questions-list>
                            </v-col>
                        </v-row>
                    </custom-card>
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
import CustomCardTitle from "../../_General/CustomCardTitle";
import {hasUniversityRole} from "../../../plugins/acl";

export default {
    name: "TheUniversityQuestionnaire",

    components: {
        CustomCardTitle,
        CreateQuestionnaireDialog,
        QuestionnaireAnswersList,
        CustomCard,
        PageDetailsHeader,
        PageTitle, PageLoader, QuestionnaireQuestionsList, QuestionnairesListItem, ExpandCard
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
            university: 'university/university',
            questionnaire: 'questionnaire/questionnaire',
            isQuestionnaireLoading: 'questionnaire/isQuestionnaireLoading',
            isQuestionnaireQuestionsLoading: 'questionnaire/isQuestionnaireQuestionsLoading'
        }),
    },

    methods: {
        hasUniversityRole,

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
                {
                    text: this.university.name ?? 'Uczelnia',
                    to: {name: 'university', params: {slug: this.$route.params.slug}},
                    exact: true
                },
                {text: 'Ankiety', to: {name: 'university-questionnaires'}, exact: true},
                {
                    text: this.questionnaire.name,
                    to: {
                        name: 'university-questionnaire',
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
