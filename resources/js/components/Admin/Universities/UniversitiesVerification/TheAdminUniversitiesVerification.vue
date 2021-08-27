<template>
    <v-container fluid class="pa-0">
        <v-row>
            <v-col cols="12">
                <custom-card>
                    <the-admin-universities-to-verification-list
                        :search="search"
                    ></the-admin-universities-to-verification-list>
                </custom-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import CustomCard from "../../../_General/CustomCard";
import PageTitle from "../../../_Helpers/PageTitle";
import TheAdminUniversitiesToVerificationList from "./TheAdminUniversitiesToVerificationList";
import {mapActions} from "vuex";

export default {
    name: "TheAdminUniversitiesVerification",
    components: {TheAdminUniversitiesToVerificationList, CustomCard, PageTitle},

    data() {
        return {
            search: null,
        }
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
        })
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Panel Administratora', to: {name: 'admin'}, exact: true},
            {text: 'Uczelnie do weryfikacji', disabled: true}
        ]);
    }
}
</script>

<style scoped>

</style>
