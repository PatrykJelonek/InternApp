<template>
    <expand-card
        title="Pytania"
    >
        <questionnaires-list-item
        :original-questions="this.questionnaire.questions"
        :questionnaire-id="this.questionnaire.id"
        ></questionnaires-list-item>
    </expand-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";
import QuestionnairesListItem from "../../Questionnaires/QuestionnairesListItem";

export default {
    name: "TheCompanyQuestionnaire",
    components: {QuestionnairesListItem, ExpandCard},
    computed: {
        ...mapGetters({
            questionnaire: 'questionnaire/questionnaire',
            isQuestionnaireLoading: 'questionnaire/isQuestionnaireLoading',
        }),
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            fetchQuestionnaire: 'questionnaire/fetchQuestionnaire'
        }),
    },

    created() {
        this.fetchQuestionnaire(this.$route.params.questionnaireId).then(() => {
            this.setBreadcrumbs([
                {text: 'Panel', to: {name: 'panel'}, exact: true},
                {text: 'Firma', to: {name: 'company', params: {slug: this.$route.params.slug}}, exact: true},
                {text: 'Ankiety', to: {name: 'company-questionnaires'}, exact: true},
                {text: this.questionnaire.name, to: {name: 'company-questionnaire', params: {slug: this.$route.params.slug, questionnaireId: this.$route.params.questionnaireId}}, exact: true},
            ]);
        }). catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
