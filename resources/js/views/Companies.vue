<template>
    <v-container fluid class="pa-10" v-bind:class="{ 'fill-height': userCompanies.length == 0 }">
        <v-row v-if="userCompanies.length > 0" class="d-flex flex-column px-5">
            <v-row class="d-flex align-center justify-space-between">
                <v-col class="pa-0">
                    <h2 class="text-uppercase title font-weight-black grey--text text--darken-4">Zarządzaj Firmą</h2>
                </v-col>
                <v-col cols="4" class="d-flex align-center justify-center">
                    <v-select
                        v-model="chosenCompany"
                        :items="userCompanies"
                        item-text="name"
                        item-value="id"
                        label="Wybierz Firmę"
                        outlined
                        dense
                        hide-details
                        @change="selectCompany(getSelectedCompany())"
                    ></v-select>
                    <v-menu offset-y>
                        <template v-slot:activator="{ on }">
                            <v-btn icon color="grey darken-2" class="ml-4" v-on="on">
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                        </template>
                        <v-list dense>
                            <company-use-code-dialog></company-use-code-dialog>
                            <v-list-item  to="create-company" dense>
                                <v-list-item-title>Stwórz nową</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-col>
            </v-row>
            <v-row v-if="!isLoading">
                <company-code-card></company-code-card>
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
    import CompanyCodeCard from "../components/Companies/CompanyCodeCard";
    import CompanyUseCodeDialog from "../components/Companies/CompanyUseCodeDialog";

    export default {
        name: "Companies",
        components: {CompanyUseCodeDialog, CompanyCodeCard, CompaniesNotFound},

        data() {
            return {
                chosenCompany: '',
                isLoading: true,
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
                selectCompany: 'company/selectCompany'
            }),

            getSelectedCompany() {
                return this.userCompanies.find((company, index) => {
                    if(company.id === this.chosenCompany)
                        return true;
                });
            }
        },

        created() {
            this.fetchUserCompanies().then(() => {
                this.chosenCompany = this.userCompanies[0];
                this.selectCompany(this.userCompanies[0]).then(() => {
                    this.isLoading = false;
                });
            });
        },
    }
</script>

<style scoped>

</style>
