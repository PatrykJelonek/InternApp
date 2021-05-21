<template>
    <div>
        <v-row>
            <v-col cols="12">
                <the-university-agreements-list></the-university-agreements-list>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import TheUniversityAgreementsList from "./TheUniversityAgreementsList";
import {mapActions} from "vuex";

export default {
    name: "TheUniversityAgreements",
    components: {TheUniversityAgreementsList},

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Uczelnia', to: {name: 'university', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Umowy', to: {name: 'university-agreements', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
