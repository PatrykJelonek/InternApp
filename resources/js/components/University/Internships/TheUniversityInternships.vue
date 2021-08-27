<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Praktyki i staże</template>
            <template v-slot:subheader>
                Lista praktyk i staży przypisanych do {{ university.name }}.
            </template>
        </page-title>

        <v-row no-gutters>
            <v-col cols="12">
                <custom-card>
                    <v-text-field
                        v-model="search"
                        outlined
                        prepend-inner-icon="mdi-magnify"
                        label="Szukaj"
                        hide-details
                    ></v-text-field>
                </custom-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <the-university-internships-list :search="search"></the-university-internships-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import TheUniversityInternshipsList from "./TheUniversityInternshipsList";
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";

export default {
    name: "TheUniversityInternships",
    components: {CustomCard, PageTitle, TheUniversityInternshipsList},

    data() {
        return {
            search: null,
        }
    },

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
