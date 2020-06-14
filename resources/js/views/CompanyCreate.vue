<template>
    <v-container fluid class="pa-0 ma-0">
        <page-details-header header="Nowa firma" subheader="Wypełnij formularz by dodać firmę i zarządzać praktykami w naszym serwisie!"></page-details-header>
        <v-container class="mt-5">
            <v-row class="d-flex justify-center">
                <v-col cols="12" lg="8" md="12" class="pa-0 form-width">
                    <company-create-form></company-create-form>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
    import CompanyCreateForm from "../components/Companies/CompanyCreateForm";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    export default {
        name: "CompanyCreate",
        components: {PageDetailsHeader, CompanyCreateForm}
    }
</script>

<style scoped>

</style>
