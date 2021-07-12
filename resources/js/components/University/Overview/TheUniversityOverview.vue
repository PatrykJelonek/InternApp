<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Informacje</template>
            <template v-slot:subheader>Podstawowe informacje o uczelni {{ university.name }}</template>
        </page-title>
        <v-row>
            <v-col cols="12" md="12" lg="8" xl="6">
                <the-university-details
                    :name="university.name"
                    :type="university.type.name"
                    :address="university.street + ' ' + university.street_number + ', ' + university.city.name"
                    :email="university.email"
                    :phone="university.phone"
                    :website="university.website"
                ></the-university-details>
            </v-col>
        </v-row>
    </v-container>

</template>

<script>
import TheUniversityDetails from "./TheUniversityDetails";
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";
export default {
name: "TheUniversityOverview",
    components: {PageTitle, TheUniversityDetails},

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
            {text: this.university.name ?? 'Uczelnia', to: {name: 'university', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
