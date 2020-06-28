<template>
    <v-app>
        <v-container class="d-flex justify-center align-center fill-height flex-column">
            <h1>403 - Nie masz uprawnień do tej strony!</h1>
            <v-btn color="blue accent-4" dark @click="$router.go(-1)" class="mt-5">Wróć</v-btn>
        </v-container>
    </v-app>
</template>

<script>
    export default {
        name: "NoPermissions"
    }
</script>

<style scoped>

</style>
