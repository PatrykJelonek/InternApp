<template>
    <v-container fluid class="ma-0 pa-0">
        <page-details-header header="Nowe porozumienie" subheader="Wypełnij poniższy formularz by dodać porozumienie z firmą!"></page-details-header>
        <v-container class="mt-5">
            <v-row class="d-flex justify-center">
                <v-col cols="10">
                    <agreement-create-form :offer-id="$route.params.offerId"></agreement-create-form>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import AgreementCreateForm from "../components/Agreements/AgreementCreateForm";
    export default {
        name: "AgreementCreate",

        components: {AgreementCreateForm, PageDetailsHeader},

        data() {
            return {

            }
        },
    }
</script>

<style scoped>

</style>
