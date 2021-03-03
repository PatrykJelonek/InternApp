<template>
    <v-snackbar
        v-model="snackbar.snackbarShow"
        :timeout="8000"
        color="cardBackground"
        right
        bottom
    >
        {{ snackbar.snackbarMessage }}
        <template v-slot:action="{ attrs }">
            <v-btn
                :color="snackbar.snackbarColor"
                text
                v-bind="attrs"
                @click="closeSnackbar"
            >
                Zamknij
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Snackbar",

    computed: {
        ...mapGetters({
            snackbar: 'snackbar/getSnackbar'
        })
    },

    methods: {
        ...mapActions({
            closeSnackbar: 'snackbar/closeSnackbar',
        }),
    }
}
</script>

<style scoped>

</style>
