<template>
    <v-container fluid>
        <v-app-bar color="transparent" flat app>
            <v-toolbar-title>{{selectedUniversity.name}}</v-toolbar-title>
        </v-app-bar>
        <v-row>
            <v-col
                offset-sm="5"
                offset-md="6"
                offset-lg="8"
            >
                <v-select
                    v-model="chosenUniversity"
                    :items="userUniversities"
                    item-text="name"
                    item-value="id"
                    label="Wybierz Uniwersytet"
                    outlined
                    dense
                    hide-details
                    class="mb-10"
                    @change="alla()"
                ></v-select>
            </v-col>
        </v-row>
        <v-row no-gutters>
            <v-col>
                <v-tabs
                    centered
                    show-arrows
                    background-color="transparent"
                >
                    <v-tab :to="{name: 'university-overview'}">Przegląd</v-tab>
                    <v-tab :to="{name: 'university-internships-list'}">Praktyki</v-tab>
                    <v-tab :to="{name: 'university-workers-list'}">Pracownicy</v-tab>
                    <v-tab :to="{name: 'university-students-list'}">Studenci</v-tab>
                    <v-tab :to="{name: 'university-settings'}">Ustawienia</v-tab>
                </v-tabs>
            </v-col>
        </v-row>
        <v-row class="mt-5">
            <router-view></router-view>
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
                selectedUniversity: 'university/selectedUniversity',
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
            },

            alla() {
                this.selectUniversity(this.getSelectedUniversity());
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
