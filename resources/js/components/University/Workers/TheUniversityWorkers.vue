<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Pracownicy</template>
            <template v-slot:subheader>
                Lista pracowników przypisanych do {{ university.name }}.
            </template>
            <template v-slot:actions>
                <v-btn color="primary" outlined>Dodaj studenta</v-btn>
            </template>
        </page-title>
        <v-row>
            <v-col cols="12">
                <the-university-workers-list></the-university-workers-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import TheUniversityWorkersList from "./TheUniversityWorkersList";
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";
export default {
    name: "TheUniversityWorkers",
    components: {PageTitle, TheUniversityWorkersList},

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
            {text: 'Pracownicy', to: {name: 'university-workers', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
