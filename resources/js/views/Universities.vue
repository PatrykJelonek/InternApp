<template>
    <v-container fluid class="pa-10" v-bind:class="{ 'fill-height': userUniversities.length == 0 }">
        <v-row v-if="userUniversities.length > 0" class="d-flex flex-column px-5">
            <v-row class="d-flex align-center justify-space-between">
                <v-col class="pa-0">
                    <h2 class="text-uppercase title font-weight-black grey--text text--darken-4">Zarządzaj Uczelnią</h2>
                </v-col>
                <v-col cols="4" class="d-flex align-center justify-center">
                    <v-select
                        v-model="chosenUniversity"
                        :items="userUniversities"
                        item-text="name"
                        item-value="id"
                        label="Wybierz Uniwersytet"
                        outlined
                        dense
                        hide-details
                        @change="selectUniversity(getSelectedUniversity())"
                    ></v-select>
                    <v-menu offset-y>
                        <template v-slot:activator="{ on }">
                            <v-btn icon color="grey darken-2" class="ml-4" v-on="on">
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                        </template>
                        <v-list dense>
                            <university-access-code-dialog></university-access-code-dialog>
                            <v-list-item  to="create-university" dense>
                                <v-list-item-title>Stwórz nową</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-col>
            </v-row>
            <v-row v-if="!isLoading">
                <university-access-code></university-access-code>
            </v-row>

            <v-row class="mt-10">
                <v-col>
                    <v-tabs v-model="tab" background-color="transparent" color="blue accent-4">
                        <v-tab>Umowy</v-tab>
                        <v-tab>Praktyki</v-tab>
                        <v-tab v-can="['view-university-students']">Studenci</v-tab>
                    </v-tabs>
                    <v-tabs-items class="transparent mt-5 body-2 text-justify" v-model="tab">
                        <v-tab-item>
                            <v-card outlined>
                                <v-data-table
                                    :headers="headers"
                                    :items="universityAgreements"
                                    :items-per-page="5"
                                    :loading="isLoading"
                                    @click:row="(item) => {this.$router.push({name: '/agreement', params: {id: item.id}})}"
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
                            <universities-internships-list></universities-internships-list>
                        </v-tab-item>
                        <v-tab-item>
                            <university-interns-list></university-interns-list>
                        </v-tab-item>
                    </v-tabs-items>
                </v-col>
            </v-row>
        </v-row>

        <v-row class="d-flex" v-else>
            <v-col cols="12">
                <universities-not-found></universities-not-found>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import UniversitiesNotFound from "../components/Universities/UniversitiesNotFound";
    import UniversityAccessCode from "../components/Universities/UniversityAccessCode";
    import UniversityAccessCodeDialog from "../components/Universities/UniversityAccessCodeDialog";
    import UniversitiesInternshipsList from "../components/Universities/UniversitiesInternshipsList";
    import UniversityInternsList from "../components/Universities/UniversityInternsList";

    export default {
        name: "Universities",

        props: ['tab'],

        components: {
            UniversityInternsList,
            UniversitiesInternshipsList, UniversityAccessCodeDialog, UniversityAccessCode, UniversitiesNotFound},

        data() {
            return {

                chosenUniversity: '',
                isLoading: true,
                headers: [
                    {text: "Nazwa", value: 'offer.name'},
                    {text: "Firma", value: 'company.name'},
                    {text: "Od", value: 'date_from'},
                    {text: "Do", value: 'date_to'},
                    {text: "Status", value: 'is_active'},
                ],
                internshipsHeaders: [
                    {text: "Supervisor", value: "company_supervisor_id"}
                ],
                sidebarItems: [
                    {
                        header: 'Ala ma kota',
                        items: [
                            {
                                text: 'Umowy',
                                link: 'agreements',
                            },
                            {
                                text: 'Studenci',
                                link: 'students',
                            }

                        ]
                    },
                    {
                        header: 'Inne',
                        items: [
                            {
                                text: 'Inne',
                                link: 'other'
                            },
                            {
                                text: 'Ustawienia',
                                link: 'settings'
                            }
                        ]
                    }
                ],
            }
        },

        computed: {
            ...mapGetters({
                userUniversities: 'user/userUniversities',
                universityAgreements: 'university/universityAgreements',
                internships: 'university/internships',
            }),
        },

        methods: {
            ...mapActions({
                fetchUserUniversities: 'user/fetchUserUniversities',
                selectUniversity: 'university/selectUniversity',
                fetchUniversityAgreements: 'university/fetchUniversityAgreements',
                selectUniversityId: 'university/selectUniversityId',
                fetchInternships: 'university/fetchInternships',
                setSidebarItems: 'sidebar/setItems'
            }),

            getSelectedUniversity() {
                return this.userUniversities.find((university, index) => {
                    if(university.id === this.chosenUniversity)
                    {
                        this.fetchInternships(this.chosenUniversity);
                        this.fetchUniversityAgreements(this.chosenUniversity);
                        return true;
                    }
                });
            }
        },

        created() {
            this.fetchUserUniversities().then(() => {
                this.chosenUniversity = this.userUniversities[0];
                this.selectUniversityId(this.userUniversities[0].id);
                this.fetchUniversityAgreements(this.userUniversities[0].id);
                this.fetchInternships(this.userUniversities[0].id);
                this.selectUniversity(this.userUniversities[0]).then(() => {
                    this.isLoading = false;
                });
            });

            this.setSidebarItems(this.sidebarItems);
        },

    }
</script>

<style scoped>

</style>
