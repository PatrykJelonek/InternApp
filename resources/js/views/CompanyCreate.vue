<template>
    <v-container fluid class="pa-10 fill-height">
        <v-row no-gutters class="d-flex flex-column">
            <v-row>
                <v-col>
                    <h2 class="font-weight-medium title font-weight-bold pa-0 ma-2 text-center text-uppercase">Dodaj firmę</h2>
                    <p class="subtitle-2 pa-0 ma-2 text-center">Wypełnij formularz by dodać firmę i zarządzać praktykami w naszym serwisie!</p>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="12" lg="6" md="12" class="pa-0 form-width">
                    <company-create-form></company-create-form>
                </v-col>
            </v-row>
        </v-row>
    </v-container>
</template>

<script>
    import CompanyCreateForm from "../components/Companies/CompanyCreateForm";
    export default {
        name: "CompanyCreate",
        components: {CompanyCreateForm}
    }
</script>

<style scoped>

</style>
