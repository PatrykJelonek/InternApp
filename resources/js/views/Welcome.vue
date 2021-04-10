<template>
    <v-container fluid>
        <v-row class="mt-10">
            <v-col>
                <h2 class="text--welcome text-h3 font-weight-black">Cześć, <br> {{user.first_name + " " + user.last_name}}</h2>
            </v-col>
        </v-row>
        <v-row class="mt-10">
            <v-col cols="12" md="6" lg="6">
                <the-dashboard-internships></the-dashboard-internships>
            </v-col>
            <v-col cols="12" md="6" lg="6">
                <the-dashboard-messages></the-dashboard-messages>
            </v-col>
            <v-col cols="12" md="12" lg="8">
                <the-dashboard-activity></the-dashboard-activity>
            </v-col>
            <v-col cols-="12" md="6" lg="4">
                <the-dashboard-others></the-dashboard-others>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import VuexTabsItems from "../components/_Helpers/VuexTabsItems";
    import Sidebar from "../components/_Helpers/Sidebar";
    import {mapActions, mapGetters} from "vuex";
    import TheDashboardInternships from "../components/Dashboard/TheDashboardInternships";
    import TheDashboardMessages from "../components/Dashboard/TheDashboardMessages";
    import TheDashboardActivity from "../components/Dashboard/TheDashboardActivity";
    import TheDashboardOthers from "../components/Dashboard/TheDashboardOthers";

    export default {
        name: "Welcome",
        components: {
            TheDashboardOthers,
            TheDashboardActivity, TheDashboardMessages, TheDashboardInternships, VuexTabsItems, Sidebar},

        data() {
            return {

            }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
        },

        methods: {
            ...mapActions({

            }),
        },

        created() {

        },
    }
</script>

<style scoped>
    .text--welcome {
        font-size: 35px;
    }
</style>
