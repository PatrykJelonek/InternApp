<template>
    <v-container fluid class="pa-0">
        <questionnaires-list></questionnaires-list>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import QuestionnairesList from "../../Questionnaires/QuestionnairesList";

export default {
    name: "TheUniversityQuestionnaires",
    components: {QuestionnairesList},
    computed: {
        ...mapGetters({
            university: 'university/university',
            universityLoading: 'university/universityLoading',
        }),
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Uczelnia', to: {name: 'university', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Ankiety', to: {name: 'university-questionnaires'}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
