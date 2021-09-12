<template>
    <v-container fluid class="pa-0">
        <v-row>
            <v-col cols="12">
                <custom-card>
                    <the-admin-companies-to-verifications-list></the-admin-companies-to-verifications-list>
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
    components: {TheAdminCompaniesToVerificationsList, CustomCard}
}
</script>

<style scoped>

</style>
