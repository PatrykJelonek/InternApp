<template>
    <v-container fluid class="pa-0">
        <v-row no-gutters>
            <v-col cols="12">
                <custom-card>
                    <v-text-field
                        v-model="search"
                        outlined
                        prepend-inner-icon="mdi-magnify"
                        label="Szukaj"
                        hide-details
                    ></v-text-field>
                </custom-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <custom-card>
                    <the-admin-companies-to-verifications-list
                        :search="search"
                    ></the-admin-companies-to-verifications-list>
                </custom-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import CustomCard from "../../../_General/CustomCard";
import TheAdminCompaniesToVerificationsList from "./TheAdminCompaniesToVerificationsList";

export default {
    name: "TheAdminCompaniesToVerification",
    components: {TheAdminCompaniesToVerificationsList, CustomCard},

    data() {
        return {
            search: null,
        }
    },
}
</script>

<style scoped>

</style>
