<template>
    <v-container>
        <div v-if="!universityLoading && !university.length > 0">
            <page-title>{{ university.name }}</page-title>
            <v-row>
                <v-col cols="12">
                    <the-university-sub-pages></the-university-sub-pages>
                </v-col>
            </v-row>
            <v-row>
                <v-container fluid>
                    <router-view></router-view>
                </v-container>
            </v-row>
        </div>
        <div v-else class="mt-15 text-center">
            <v-progress-circular
                indeterminate
                size="100"
                width="8"
                color="primary"
            ></v-progress-circular>
        </div>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../components/_Helpers/PageTitle";
import TheUniversitySubPages from "../components/University/TheUniversitySubPages";

export default {
    name: "University",
    components: {TheUniversitySubPages, PageTitle},
    computed: {
        ...mapGetters({
            university: 'university/university',
            universityLoading: 'university/universityLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchUniversity: 'university/fetchUniversity',
        }),
    },

    created() {
        this.fetchUniversity(this.$route.params.slug).then(() => {

        }).catch((e) => {

        })
    }
}
</script>

<style scoped>

</style>
