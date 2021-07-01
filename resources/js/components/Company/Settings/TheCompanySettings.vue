<template>
    <v-container fluid class="pa-0">
        <template v-if="!companyLoading">
            <page-title>
                <template v-slot:default>Ustawienia</template>
                <template v-slot:subheader>Ustawienia firmy {{ company.name }}</template>
            </page-title>

            <v-row>
                <v-col cols="12" md="4" lg="3" xl="2">
                   <the-company-settings-logo></the-company-settings-logo>
                </v-col>
                <v-col cols="12" md="8" lg="9" xl="6">
                    <the-company-settings-data></the-company-settings-data>
                </v-col>
            </v-row>
        </template>
        <template v-else>
            <page-loader></page-loader>
        </template>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";
import PageLoader from "../../_General/PageLoader";
import TheCompanySettingsLogo from "./TheCompanySettingsLogo";
import TheCompanySettingsData from "./TheCompanySettingsData";

export default {
    name: "TheCompanySettings",
    components: {TheCompanySettingsData, TheCompanySettingsLogo, PageLoader, PageTitle},

    computed: {
        ...mapGetters({
            company: 'company/company',
            companyLoading: 'company/companyLoading'
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
            {text: 'Firma', to: {name: 'company', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Ustawienia', to: {name: 'company-settings'}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
