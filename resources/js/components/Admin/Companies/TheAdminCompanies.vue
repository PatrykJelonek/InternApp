<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Firmy</template>
            <template v-slot:subheader>Lista firm w serwisie</template>
            <template v-slot:actions>
                <v-btn-toggle>
                    <v-btn
                        small
                        :to="{name: 'admin-companies'}" exact
                    >
                        Wszystkie
                    </v-btn>
                    <v-btn
                        small
                        :to="{name: 'admin-companies-verification'}" exact
                    >
                        Do weryfikacji
                    </v-btn>
                </v-btn-toggle>
            </template>
        </page-title>

        <v-row no-gutters>
            <v-col cols="12">
                <custom-card>

                </custom-card>
            </v-col>
        </v-row>

        <v-row no-gutters class="pt-10">
            <v-col cols="12">
                <router-view></router-view>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";
import {mapActions} from "vuex";

export default {
    name: "TheAdminCompanies",
    components: {CustomCard, PageTitle},

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
        })
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Panel Administratora', to: {name: 'admin'}, exact: true},
            {text: 'Firmy', disabled: true}
        ]);
    }
}
</script>

<style scoped>

</style>
