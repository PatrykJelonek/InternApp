<template>
    <v-app>
        <v-container class="d-flex flex-column justify-center align-center fill-height">
            <h1 class="text-h1 font-weight-bold primary--text">Ups...</h1>
            <h2 class="text-h5 mt-5">Nie udało znaleźć się strony której szukasz.</h2>
            <p class="body-1 mt-5">Status: <code>404</code></p>
            <p>{{ $route.path }}</p>
            <v-btn
                outlined
                color="primary"
                class="mt-5"
                @click="$router.go(-2)"
            >
                Cofnij
            </v-btn>
            <v-btn
                outlined
                color="primary"
                class="mt-5"
                @click="$router.push({name: 'landing-page'})"
            >
                Strona Główna
            </v-btn>
        </v-container>
    </v-app>
</template>

<script>
    export default {
        name: "NotFound"
    }
</script>

<style lang="scss" scoped>
    body {
        height: 100vw;
    }
</style>
