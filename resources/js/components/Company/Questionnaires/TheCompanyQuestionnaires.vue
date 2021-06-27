<template>
    <v-container fluid class="pa-0">
        <template v-if="!companyLoading || !isQuestionnairesLoading">
            <create-questionnaire-dialog :is-company-questionnaire="true"></create-questionnaire-dialog>

            <page-title>
                <template v-slot:default>Ankiety</template>
                <template v-slot:subheader>Lista ankiet firmy {{ company.name }}</template>
                <template v-slot:actions>
                    <v-btn color="primary" outlined @click="toggleCreateQuestionnaireDialog(true)">Dodaj Ankietę</v-btn>
                </template>
            </page-title>

            <v-row class="mt-7">
                <v-col cols="12">
                    <v-data-table
                        :headers="headers"
                        :items="questionnaires"
                        :item-key="questionnaires.id"
                        class="component-background cursor-pointer"
                        @click:row="(questionnaire) => this.$router.push({name: 'company-questionnaire', params: {slug: this.$route.params.slug, questionnaireId: questionnaire.id}})"
                    >
                        <template v-slot:item.user="{item}">
                            <v-avatar :size="30" class="mr-2" :color="item.user.avatar_url ? '' : 'primary'">
                                <v-img :src="item.user.avatar_url ? '/'+item.user.avatar_url : ''" :alt="'Awatar użytkownika ' + item.user.full_name"></v-img>
                            </v-avatar>
                            {{ item.user.full_name }}
                        </template>
                        <template v-slot:item.questions="{item}">
                            {{ item.questions.length }}
                        </template>
                        <template v-slot:item.created_at="{item}">
                            {{ formatDate(item.created_at) }}
                        </template>
                    </v-data-table>
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
import QuestionnairesList from "../../Questionnaires/QuestionnairesList";
import QuestionnairesStatisticCount from "../../Questionnaires/QuestionnairesStatisticCount";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import CreateQuestionnaireDialog from "../../Questionnaires/CreateQuestionnaireDialog";
import PageTitle from "../../_Helpers/PageTitle";
import moment from "moment";
import PageLoader from "../../_General/PageLoader";

export default {
    name: "TheCompanyQuestionnaires",
    components: {
        PageLoader,
        PageTitle,
        CreateQuestionnaireDialog,
        CustomCardTitle,
        CustomCard,
        QuestionnairesStatisticCount,
        QuestionnairesList
    },

    data() {
        return {
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Autor', value: 'user'},
                {text: 'Liczba pytań', value: 'questions'},
                {text: 'Data utworzenia', value: 'created_at'}
            ]
        }
    },

    computed: {
        ...mapGetters({
            company: 'company/company',
            companyLoading: 'company/companyLoading',
            questionnaires: 'questionnaire/questionnaires',
            isQuestionnairesLoading: 'questionnaire/isQuestionnairesLoading',
        }),
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            fetchQuestionnaires: 'questionnaire/fetchCompanyQuestionnaires',
            toggleCreateQuestionnaireDialog: 'helpers/toggleCreateQuestionnaireDialog',
            fetchCompany: 'company/fetchCompany'
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY - HH:mm');
        }
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Firma', to: {name: 'company', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Ankiety', to: {name: 'company-questionnaires'}, exact: true},
        ]);

        this.fetchQuestionnaires(this.$route.params.slug).then(() => {

        }).catch((error) => {

        })
    }
}
</script>

<style scoped>

</style>
