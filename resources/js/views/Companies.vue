<template>
    <v-container fluid class="pa-10" v-bind:class="{ 'fill-height': userCompanies.length == 0 }">
        <v-row v-if="userCompanies.length > 0" class="d-flex flex-column px-5">
            <v-row class="d-flex align-center justify-space-between">
                <v-col class="pa-0">
                    <h2 class="text-uppercase title font-weight-black grey--text text--darken-4">Zarządzaj Firmą</h2>
                </v-col>
                <v-col cols="4" class="d-flex align-center justify-center">
                    <v-select
                        v-model="chosenCompanies"
                        :items="userCompanies"
                        item-text="name"
                        item-value="id"
                        label="Wybierz Firmę"
                        outlined
                        dense
                        hide-details
                    ></v-select>
                    <v-btn icon color="grey darken-2" class="ml-4" to="create-company">
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-row>
        <v-row class="d-flex" v-else>
            <v-col cols="12">
                <companies-not-found></companies-not-found>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import CompaniesNotFound from "../components/Companies/CompaniesNotFound";

    export default {
        name: "Companies",
        components: {CompaniesNotFound},

        data() {
            return {
                chosenCompanies: ''
            }
        },

        computed: {
            ...mapGetters({
                userCompanies: 'user/userCompanies',
            }),
        },

        methods: {
            ...mapActions({
                fetchUserCompanies: 'user/fetchUserCompanies',
            }),
        },

        created() {
            this.fetchUserCompanies().then(() => {
                this.chosenCompanies = this.userCompanies[0];
            });
        },
    }
</script>

<style scoped>

</style>
