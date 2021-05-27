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
import {mapActions} from "vuex";
export default {
    name: "TheAdminSettings",
    components: {TheAdminSettingsOfferCategories, TheAdminSettingsOfferStatuses},

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Panel Administratora', to: {name: 'admin'}, exact: true},
            {text: 'Ustawienia', disabled: true}
        ]);
    }
}
</script>

<style scoped>

</style>
