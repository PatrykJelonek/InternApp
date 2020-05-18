<template>
    <v-container fluid class="pa-10 fill-height">
        <v-row class="px-5 d-flex flex-column justify-center align-center mt-10">
            <v-row>
                <v-col>
                    <h2 class="font-weight-medium title font-weight-bold pa-0 ma-2 text-center text-uppercase">Dodaj uczelnie</h2>
                    <p class="subtitle-2 pa-0 ma-2 text-center">Wypełnij formularz by dodać uczelnie i zarządzać praktykami w naszym serwisie!</p>
                </v-col>
            </v-row>
            <v-row>
                <v-col class="pa-0">
                    <university-create-form></university-create-form>
                </v-col>
            </v-row>
        </v-row>
    </v-container>
</template>

<script>
    import UniversityCreateForm from "../components/Universities/UniversityCreateForm";
    export default {
        name: "UniversityCreate",
        components: {UniversityCreateForm}
    }
</script>

<style scoped>

</style>
