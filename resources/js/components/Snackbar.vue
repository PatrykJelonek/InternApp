<template>
    <v-snackbar v-model="snackbar" :color="color" bottom right>
        {{message}}
        <v-btn icon dark @click="snackbar = false">
            <v-icon>mdi-close</v-icon>
        </v-btn>
    </v-snackbar>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Snackbar",

        data() {
            return {
                snackbar: false,
                message: '',
                color: ''
            }
        },

        computed: {
            ...mapGetters({
                message: 'snackbar/message',
                color: 'snackbar/color'
            }),
        },
    }
</script>

<style scoped>

</style>
