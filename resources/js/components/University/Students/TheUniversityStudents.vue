<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Studenci</template>
            <template v-slot:subheader>
                Lista studentów przypisanych do {{ university.name }}.
            </template>
            <template v-slot:actions>
                <v-btn color="primary" outlined>Dodaj studenta</v-btn>
            </template>
        </page-title>

        <v-row>
            <v-col cols="12">
                <custom-card>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Szukaj"
                        single-line
                        hide-details
                        outlined
                    ></v-text-field>
                </custom-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <the-university-students-list :search="search"></the-university-students-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import TheUniversityStudentsList from "./TheUniversityStudentsList";
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";
export default {
    name: "TheUniversityStudents",
    components: {CustomCard, PageTitle, TheUniversityStudentsList},

    data() {
        return {
            search: '',
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
            {text: 'Studenci', to: {name: 'university-students', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
