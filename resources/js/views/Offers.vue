<template>
    <v-container fluid>
        <page-title>{{ $route.meta.title ? $route.meta.title : 'Oferty Praktyk' }}</page-title>
        <v-row v-has="['student']">
            <v-col cols="12">
                <v-card elevation="0" color="card-background">
                    <v-tabs background-color="card-background">
                        <v-tab v-has="['student']" :to="{name: 'offers'}">Dostępne oferty</v-tab>
                        <v-tab v-has="['student']" :to="{name: 'internship-applications'}">Aplikacje na praktyki</v-tab>
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
    import {mapActions} from "vuex";

    export default {
        name: "Offers",

        components: {TheStudentOfferApplicationsList, StudentOffersList, PageTitle, PageDetailsHeader, OffersList},

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

        methods: {
            ...mapActions({
                setBreadcrumbs: 'helpers/setBreadcrumbs'
            }),
        },

        created() {
            this.setBreadcrumbs([
                {text: 'Panel', to: {name: 'panel'}, exact: true},
                {text: 'Oferty Praktyk', to: {name: 'offers'}, exact: true},
            ]);
        }
    }
</script>

<style scoped>

</style>
