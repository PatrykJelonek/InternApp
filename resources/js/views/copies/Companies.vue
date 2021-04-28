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
            <v-row v-if="!isLoading.code">
                <company-code-card></company-code-card>
            </v-row>

            <v-row class="mt-10">
                <v-col>
                    <v-tabs v-model="tab" background-color="transparent" color="blue accent-4">
                        <v-tab>Oferty</v-tab>
                        <v-tab>Umowy</v-tab>
                        <v-tab>Praktykanci</v-tab>
                    </v-tabs>
                    <v-tabs-items class="transparent mt-5 body-2 text-justify" v-model="tab">
                        <v-tab-item>
                            <v-card outlined>
                                <v-data-table
                                    :headers="offersHeaders"
                                    :items="companyOffers"
                                    :items-per-page="5"
                                    :loading="isLoading.offersTable"
                                    @click:row="(item) => {this.$router.push({name: 'offer', params: {id: item.id}})}"
                                ></v-data-table>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card outlined>
                                <v-data-table
                                    :headers="agreementsHeaders"
                                    :items="companyAgreements"
                                    :items-per-page="5"
                                    :loading="isLoading.agreementsTable"
                                    @click:row="(item) => {this.$router.push({name: 'agreement', params: {id: item.id}})}"
                                >
                                    <template v-slot:item.is_active="{ item }">
                                        <v-chip :color="item.is_active ? 'success':'error' " dark>
                                            {{item.is_active ? 'Aktywny':'Nieaktywny'}}
                                        </v-chip>
                                    </template>
                                </v-data-table>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <company-interns></company-interns>
                        </v-tab-item>
                    </v-tabs-items>
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
    import CompanyCodeCard from "../components/Companies/CompanyCodeCard";
    import CompanyUseCodeDialog from "../components/Companies/CompanyUseCodeDialog";
    import CompanyInterns from "../components/Companies/CompanyInterns";

    export default {
        name: "Companies",
        components: {CompanyInterns, CompanyUseCodeDialog, CompanyCodeCard, CompaniesNotFound},

        data() {
            return {
                tab: null,
                chosenCompany: '',
                isLoading: {
                    code: true,
                    offersTable: true,
                    agreementsTable: true,
                },
                offersHeaders: [
                    { text: 'Nazwa', value: 'name' },
                    { text: 'Ilość miejsc', value: 'places_number' },
                    { text: 'Kategoria', value: 'offer_category.name' },
                ],
                agreementsHeaders: [
                    {text: "Nazwa", value: 'offer.name'},
                    {text: "Uczelnia", value: 'university.name'},
                    {text: "Od", value: 'date_from'},
                    {text: "Do", value: 'date_to'},
                    {text: "Status", value: 'is_active'},
                ]
            }
        },

        computed: {
            ...mapGetters({
                userCompanies: 'user/userCompanies',
                companyAgreements: 'company/companyAgreements',
                companyOffers: 'company/companyOffers',
                selectedCompanyId: 'company/selectedCompanyId'
            }),
        },

        methods: {
            ...mapActions({
                fetchUserCompanies: 'user/fetchUserCompanies',
                selectCompany: 'company/selectCompany',
                fetchCompanyAgreements: 'company/fetchCompanyAgreements',
                fetchCompanyOffers: 'company/fetchCompanyOffers',
                fetchCompanyInterns: 'company/fetchInterns',
                selectCompanyId: 'company/selectCompanyId',
            }),

            getSelectedCompany() {
                this.isLoading.offersTable = true;
                this.isLoading.agreementsTable = true;

                return this.userCompanies.find((company, index) => {
                    if(company.id === this.chosenCompany)
                    {
                        this.selectCompanyId(company.id);
                        this.fetchCompanyInterns(this.chosenCompany);
                        this.fetchCompanyOffers(this.chosenCompany).then(() => {
                            this.isLoading.offersTable = false;
                        });
                        this.fetchCompanyAgreements(this.chosenCompany).then(() => {
                            this.isLoading.agreementsTable = false;
                        });
                        return true;
                    }

                });
            }
        },

        created() {
            this.fetchUserCompanies().then(() => {
                this.chosenCompany = this.userCompanies[0];
                this.selectCompanyId(this.userCompanies[0].id);
                this.selectCompany(this.userCompanies[0]).then(() => {
                    this.isLoading.code = false;

                    this.fetchCompanyOffers(this.chosenCompany.id).then(() => {
                        this.isLoading.offersTable = false;
                    });

                    this.fetchCompanyAgreements(this.chosenCompany.id).then(() => {
                        this.isLoading.agreementsTable = false;
                    });
                });
            });
        },
    }
</script>

<style scoped>

</style>
