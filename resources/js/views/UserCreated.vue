<template>
    <v-app class="component-background">
        <v-app-bar
            flat
            color="transparent"
            dark
            class="px-5"
            absolute
        >
            <v-toolbar-title class="font-weight-bold">Internships</v-toolbar-title>
        </v-app-bar>
        <v-container fluid class="pa-0 d-flex justify-center align-center fill-height component-background">
            <v-row no-gutters class="d-flex justify-center align-center">
                <v-col cols="6" class="text-center">
                    <v-icon color="success" large>mdi-account-check-outline</v-icon>
                    <h2>Twoje konto zostało utworzone!</h2>
                    <p class="text-body-2">Na podany, przy rejestracji, adres email został wysłany link aktywacyjny.</p>
                    <v-btn outlined color="primary" class="mt-5" :to="{name: 'login'}">Logowanie</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
import CustomCard from "../components/_General/CustomCard";
export default {
    name: "UserCreated",
    components: {CustomCard}
}
</script>

<style scoped>

</style>
