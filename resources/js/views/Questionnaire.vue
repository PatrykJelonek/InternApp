<template>
    <v-container :fluid="this.$vuetify.breakpoint.mdAndDown">
        <questions-list
        :questionnaire-name="questionnaire.name"
        :questionnaire-description="questionnaire.description"
        :questionnaire-id="questionnaire.id"
        ></questions-list>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import QuestionsList from "../components/Questionnaire/QuestionsList";

export default {
    name: "Questionnaire",
    components: {QuestionsList},
    computed: {
        ...mapGetters({
            questionnaire: 'questionnaire/questionnaire',
            isQuestionnaireLoading: 'questionnaire/isQuestionnaireLoading',
        })
    },

    methods: {
        ...mapActions({
            fetchQuestionnaire: 'questionnaire/fetchQuestionnaire',
            addQuestionnaireAnswers: 'questionnaire/addQuestionnaireAnswers',
            setBreadcrumbs: 'helpers/setBreadcrumbs',
        }),
    },

    created() {
        this.fetchQuestionnaire(this.$route.params.id).then((response) => {
            this.setBreadcrumbs([
                {text: 'Panel', to: {name: 'panel'}, exact: true},
                {text: 'Ankiety', to: {name: 'questionnaires'}, exact: true},
                {text: this.questionnaire.name, to: {name: 'questionnaire', params: {id: this.questionnaire.id}}, exact: true},
            ]);
        }).catch((response) => {

        });
    },
}
</script>

<style scoped>

</style>
