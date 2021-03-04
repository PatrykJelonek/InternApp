<template>
    <v-snackbar
        v-model="snackbar.show"
        :timeout="8000"
        color="cardBackground"
        right
        bottom
    >
        {{ snackbar.message }}
        <template v-slot:action="{ attrs }">
            <v-btn
                :color="snackbar.color"
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
            snackbar: 'snackbar/snackbar'
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
