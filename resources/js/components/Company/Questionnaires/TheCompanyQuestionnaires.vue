<template>
    <h1>Questionnaires</h1>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "TheCompanyQuestionnaires",

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
