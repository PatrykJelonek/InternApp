<template>
    <v-row>
        <v-col cols="12">
            <the-admin-settings-offer-statuses></the-admin-settings-offer-statuses>
        </v-col>
        <v-col cols="12">
            <the-admin-settings-offer-categories></the-admin-settings-offer-categories>
        </v-col>
    </v-row>
</template>

<script>
import TheAdminSettingsOfferStatuses from "./TheAdminSettingsOfferStatuses";
import TheAdminSettingsOfferCategories from "./TheAdminSettingsOfferCategories";
export default {
    name: "TheAdminSettings",
    components: {TheAdminSettingsOfferCategories, TheAdminSettingsOfferStatuses}
}
</script>

<style scoped>

</style>
