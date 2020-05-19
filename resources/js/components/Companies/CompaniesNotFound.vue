<template>
    <div>
        <v-row>
            <v-col cols="12" class="pa-0">
                <h3 class="text-center headline font-weight-light text-uppercase grey--text text--darken-1">Nie jesteś przypisany do żadnej firmy!</h3>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" class="pa-0">
                <p class="grey--text text--darken-1 text-center mt-2 mb-0">Jeżeli reprezentujesz firmę, a nie jest ona jeszcze dostępna, możesz ją dodać do naszego serwisu.</p>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" class="pa-0">
                <p class="grey--text text--darken-1 text-center">Jeśli jednak jesteś pracownikiem firmy, poproś administratora firmy o kod pozwalający na dołączenie.</p>
            </v-col>
        </v-row>
        <v-row class="mt-5">
            <v-col cols="12" class="pa-0 d-flex justify-center">
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn color="primary" outlined v-on="on" class="mr-10">Użyj Kodu</v-btn>
                    </template>
                    <span>Użyj kodu by dołączyć do firmy</span>
                </v-tooltip>

                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn color="blue accent-4" dark v-on="on" class="ml-10" to="create-company">Dodaj Firmę</v-btn>
                    </template>
                    <span>Dodaj nową firmę do serwisu</span>
                </v-tooltip>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "CompaniesNotFound"
    }
</script>

<style scoped>

</style>
