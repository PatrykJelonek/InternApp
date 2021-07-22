<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Nowa firma</template>
            <template v-slot:subheader>Wypełnij formularz by dodać firmę i zarządzać praktykami w naszym serwisie!</template>
        </page-title>

        <custom-card>
            <v-row class="pa-5">
                <v-col cols="12">
                    <company-create-form></company-create-form>
                </v-col>
            </v-row>
        </custom-card>
    </v-container>
</template>

<script>
    import CompanyCreateForm from "../components/Companies/CompanyCreateForm";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import PageTitle from "../components/_Helpers/PageTitle";
    import CustomCard from "../components/_General/CustomCard";
    export default {
        name: "CompanyCreate",
        components: {CustomCard, PageTitle, PageDetailsHeader, CompanyCreateForm}
    }
</script>

<style scoped>

</style>
