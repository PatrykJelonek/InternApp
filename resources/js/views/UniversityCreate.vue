<template>
    <v-container fluid class="pa-0 ma-0">
        <page-details-header header="Nowa uczelnia" subheader="Wypełnij formularz by dodać uczelnie i zarządzać praktykami w naszym serwisie!"></page-details-header>
        <v-container class="mt-5">
            <v-row class="d-flex justify-center">
                <v-col cols="12" lg="8" md="12" class="pa-0 form-width">
                    <university-create-form></university-create-form>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
    import UniversityCreateForm from "../components/Universities/UniversityCreateForm";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    export default {
        name: "UniversityCreate",
        components: {PageDetailsHeader, UniversityCreateForm}
    }
</script>

<style scoped>

</style>
