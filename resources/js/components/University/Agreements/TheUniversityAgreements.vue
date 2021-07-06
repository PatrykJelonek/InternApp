<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Umowy</template>
            <template v-slot:subheader>
                Lista umów przypisanych do {{ university.name }}.
            </template>
            <template v-slot:actions>
                <v-btn color="primary" outlined>Dodaj umowę</v-btn>
            </template>
        </page-title>
        <v-row>
            <v-col cols="12">
                <the-university-agreements-list></the-university-agreements-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import TheUniversityAgreementsList from "./TheUniversityAgreementsList";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "TheUniversityAgreements",
    components: {TheUniversityAgreementsList},

    computed: {
        ...mapGetters({
            university: 'university/university'
        })
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: this.university.name ?? 'Uczelnia', to: {name: 'university', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Umowy', to: {name: 'university-agreements', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
