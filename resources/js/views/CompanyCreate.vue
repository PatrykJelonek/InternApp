<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Nowa firma</template>
            <template v-slot:subheader>Wypełnij formularz by dodać firmę i zarządzać praktykami w naszym serwisie!</template>
        </page-title>

        <custom-card>
            <custom-card-title>
                <template v-slot:default>Formularz dodawania nowej firmy</template>
                <template v-slot:subheader>Wypełnij poniższy formularz by dodać nową firmę do serwisu.</template>
            </custom-card-title>

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
    import CustomCardTitle from "../components/_General/CustomCardTitle";
    export default {
        name: "CompanyCreate",
        components: {CustomCardTitle, CustomCard, PageTitle, PageDetailsHeader, CompanyCreateForm}
    }
</script>

<style scoped>

</style>
