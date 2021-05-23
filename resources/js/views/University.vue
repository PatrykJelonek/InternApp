<template>
    <v-container fluid>
        <div v-if="!universityLoading && !university.length > 0">
            <page-title :breadcrumbs="breadcrumbs">{{ university.name }}</page-title>
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

    data() {
        return {

        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            universityLoading: 'university/universityLoading',
        }),

        breadcrumbs() {
            return [
                {text: 'Panel', to: {name: 'panel'}, exact: true},
                {text: 'Uczelnia', to: {name: 'university', params: {slug: this.university.slug}}},
                {text: this.university.name, disabled: true}
            ];
        }
    },

    methods: {
        ...mapActions({
            fetchUniversity: 'university/fetchUniversity',
            setBreadcrumbs: 'helpers/setBreadcrumbs',
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
