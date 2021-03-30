<template>
    <v-row>
        <v-col cols="12">
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
import {mapGetters} from "vuex";
export default {
name: "TheUniversityOverview",
    components: {TheUniversityDetails},

    computed: {
        ...mapGetters({
            university: 'university/university',
            universityLoading: 'university/universityLoading',
        }),
    },
}
</script>

<style scoped>

</style>
