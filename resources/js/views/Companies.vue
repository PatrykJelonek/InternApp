<template>
    <v-container>
        <v-row v-id="userCompaniesLoading && userCompanies > 1">
            <v-col cols="12">
                <page-title>Lista firm</page-title>
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col cols="12">
                <page-loading></page-loading>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CompaniesNotFound from "../components/Companies/CompaniesNotFound";
import CompanyCodeCard from "../components/Companies/CompanyCodeCard";
import CompanyUseCodeDialog from "../components/Companies/CompanyUseCodeDialog";
import CompanyInterns from "../components/Companies/CompanyInterns";
import PageTitle from "../components/_Helpers/PageTitle";
import PageLoading from "../components/_Helpers/page-loading";
import PageTabHeader from "../components/_General/PageTabs";

export default {
    name: "Companies",
    components: {PageLoading, PageTitle},

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
