<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Nowa uczelnia</template>
            <template v-slot:subheader>
                Wypełnij formularz by dodać uczelnie i zarządzać praktykami w naszym serwisie!
            </template>
        </page-title>

        <custom-card>
            <custom-card-title>
                <template v-slot:default>Formularz dodawania nowej uczelni</template>
                <template v-slot:subheader>Wypełnij poniższy formularz by dodać nową uczelnie do serwisu.</template>
            </custom-card-title>

            <v-row class="pa-5">
                <v-col cols="12">
                    <university-create-form></university-create-form>
                </v-col>
            </v-row>
        </custom-card>
    </v-container>
</template>

<script>
import UniversityCreateForm from "../components/Universities/UniversityCreateForm";
import PageDetailsHeader from "../components/Page/PageDetailsHeader";
import PageTitle from "../components/_Helpers/PageTitle";
import CustomCard from "../components/_General/CustomCard";
import CustomCardTitle from "../components/_General/CustomCardTitle";

export default {
    name: "UniversityCreate",
    components: {CustomCardTitle, CustomCard, PageTitle, PageDetailsHeader, UniversityCreateForm}
}
</script>

<style scoped>

</style>
