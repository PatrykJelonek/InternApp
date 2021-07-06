<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Praktyki i staże</template>
            <template v-slot:subheader>
                Lista praktyk i staży przypisanych do {{ university.name }}.
            </template>
            <template v-slot:actions>
                <v-btn color="primary" outlined>Dodaj praktykę / staż</v-btn>
            </template>
        </page-title>
        <v-row>
            <v-col cols="12">
                <the-university-internships-list></the-university-internships-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import TheUniversityInternshipsList from "./TheUniversityInternshipsList";
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";

export default {
    name: "TheUniversityInternships",
    components: {PageTitle, TheUniversityInternshipsList},

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
            {
                text: 'Praktyki i Staże',
                to: {name: 'university-internships', params: {slug: this.$route.params.slug}},
                exact: true
            },
        ])
    }
}
</script>

<style scoped>

</style>
