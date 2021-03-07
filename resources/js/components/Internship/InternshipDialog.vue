<template>
    <div>
        <v-card
            class="pa-3 mb-3 text-center"
            color="cardBackground"
            @click="toggle"
            elevation="0"
            ripple
        >
            <v-icon>mdi-plus</v-icon>
        </v-card>
        <!-- dialog -->
        <v-dialog v-model="dialog[name].value" max-width="500">
            <v-card color="cardBackground" class="pa-5">
                <slot></slot>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "InternshipDialog",
    props: ['name'],

    computed: {
        ...mapGetters({
            dialog: 'helpers/dialog',
        })
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog'
        }),

        toggle() {
            this.toggleDialog(this.name)
        }
    }
}
</script>

<style scoped>

</style>
