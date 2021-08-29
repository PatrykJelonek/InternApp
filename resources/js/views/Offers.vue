<template>
    <v-container fluid class="pa-0">
        <create-internship-dialog></create-internship-dialog>
        <page-title>
            <template v-slot:default>Oferty Praktyk</template>
            <template v-slot:subheader>Lista ofert praktyk i staży dostępnych w serwisie</template>
            <template v-slot:actions>
                <v-btn
                    outlined
                    color="primary"
                    @click.stop="toggleDialog"
                    v-has="['student']"
                    :disabled="!userInternshipsLoading && userInternships.length > 0"
                >
                    Zgłoś własne miejsce praktyk
                </v-btn>
            </template>
        </page-title>
        <v-row v-has="['student']">
            <v-col cols="12">
                <v-card elevation="0" color="card-background">
                    <v-tabs background-color="card-background">
                        <v-tab v-has="['student']" :to="{name: 'offers'}" exact>Dostępne oferty</v-tab>
                        <v-tab v-has="['student']" :to="{name: 'internship-applications'}" exact>Aplikacje na praktyki</v-tab>
                    </v-tabs>
                </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <router-view></router-view>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import OffersList from "../components/Offers/OffersList";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import PageTitle from "../components/_Helpers/PageTitle";
    import StudentOffersList from "../components/Offers/Student/StudentOffersList";
    import TheStudentOfferApplicationsList from "../components/Offers/Student/TheStudentOfferApplicationsList";
    import {mapActions, mapGetters} from "vuex";
    import CreateInternshipDialog from "../components/Offers/Student/CreateInternshipDialog";

    export default {
        name: "Offers",

        components: {
            CreateInternshipDialog,
            TheStudentOfferApplicationsList, StudentOffersList, PageTitle, PageDetailsHeader, OffersList},

        data() {
            return {
                breadcrumbs: [
                    {
                        text: 'Dashboard',
                        to: 'dashboard'
                    },
                    {
                        text: 'Oferty',
                        to: 'offers',
                        disabled: true
                    },
                ]
            }
        },

        computed: {
            ...mapGetters({
                userInternships: 'user/internships',
                userInternshipsLoading: 'user/internshipsLoading',
            })
        },

        methods: {
            ...mapActions({
                setBreadcrumbs: 'helpers/setBreadcrumbs',
                toggleDialog: 'helpers/toggleCreateInternshipDialog',
                fetchUserInternships: 'user/fetchInternships',
            }),
        },

        created() {
            this.setBreadcrumbs([
                {text: 'Panel', to: {name: 'panel'}, exact: true},
                {text: 'Oferty Praktyk', to: {name: 'offers'}, exact: true},
            ]);

            this.fetchUserInternships().then(() => {

            }).catch((e) => {

            });
        }
    }
</script>

<style scoped>

</style>
