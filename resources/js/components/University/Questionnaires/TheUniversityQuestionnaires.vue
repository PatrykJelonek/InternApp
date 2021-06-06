<template>
    <h1>questionnaires</h1>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "TheUniversityQuestionnaires",

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
