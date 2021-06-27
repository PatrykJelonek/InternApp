<template>
    <v-container fluid class="pa-0">
        <template v-if="!companyLoading">
            <page-title>
                <template v-slot:default>{{ company.name }}</template>
                <template v-slot:subheader>Informacje o firmie {{ company.name }}</template>
            </page-title>
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

export default {
    name: "TheCompanyOverview",
    components: {PageLoader, PageTitle},

    computed: {
        ...mapGetters({
            company: 'company/company',
            companyLoading: 'company/companyLoading',
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
        ])
    }
}
</script>

<style scoped>

</style>
