<template>
    <v-container>
        <v-row v-if="userCompaniesLoading && userCompanies > 1">
            <v-col cols="12">
                <page-title>Lista firm</page-title>
            </v-col>
        </v-row>
        <v-row v-else class="text-center">
            <v-col cols="12">
                <page-loader v-if="userCompaniesLoading"></page-loader>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../components/_Helpers/PageTitle";
import PageLoader from "../components/_General/PageLoader";

export default {
    name: "Companies",
    components: {PageLoader, PageTitle},

    data() {
        return {

        }
    },

    computed: {
        ...mapGetters({
            userCompanies: 'user/userCompanies',
            userCompaniesLoading: 'user/userCompaniesLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchUserCompanies: 'user/fetchUserCompanies',
        }),
    },

    created() {
        this.fetchUserCompanies().then(() => {
            if (this.userCompanies.length === 1) {
                this.$router.push({name: 'company', params: {slug: this.userCompanies[0].slug}});
            }
        }).catch(() => {

        });
    }
}
</script>

<style scoped>

</style>
