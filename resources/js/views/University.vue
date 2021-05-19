<template>
    <v-container>
        <div v-if="!universityLoading && !university.length > 0">
            <page-title>{{ university.name }}</page-title>
            <v-row>
                <v-container fluid>
                    <router-view></router-view>
                </v-container>
            </v-row>
        </div>
        <v-row v-else class="text-center">
            <v-col cols="12">
                <page-loader></page-loader>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../components/_Helpers/PageTitle";
import TheUniversitySubPages from "../components/University/TheUniversitySubPages";
import PageLoader from "../components/_General/PageLoader";

export default {
    name: "University",
    components: {PageLoader, TheUniversitySubPages, PageTitle},
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
