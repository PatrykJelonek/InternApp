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
                <the-admin-companies-verified-list
                    :search="search"
                ></the-admin-companies-verified-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import TheAdminCompaniesVerifiedList from "./TheAdminCompaniesVerifiedList";
import CustomCard from "../../../_General/CustomCard";

export default {
    name: "TheAdminCompaniesVerified",
    components: {CustomCard, TheAdminCompaniesVerifiedList},

    data() {
        return {
            search: null,
        }
    },
}
</script>

<style scoped>

</style>
