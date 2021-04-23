<template>
    <v-container v-has="['admin']">
        <v-row>
            <v-col cols="12">
                <page-title>Panel Administratora</page-title>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-card elevation="0" color="card-background">
                    <v-tabs background-color="card-background">
                        <v-tab :to="{name: 'admin'}">Statystyki</v-tab>
                        <v-tab :to="{name: 'admin-offers'}">Oferty</v-tab>
                        <v-tab :to="{name: 'admin-users'}">Użytkownicy</v-tab>
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
import PageTitle from "../components/_Helpers/PageTitle";

export default {
    name: "Admin",
    components: {PageTitle}
}
</script>

<style scoped>

</style>
