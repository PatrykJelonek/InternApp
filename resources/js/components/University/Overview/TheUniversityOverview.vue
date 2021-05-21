<template>
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
</template>

<script>
import TheUniversityDetails from "./TheUniversityDetails";
import {mapActions, mapGetters} from "vuex";
export default {
name: "TheUniversityOverview",
    components: {TheUniversityDetails},

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
        ])
    }
}
</script>

<style scoped>

</style>
