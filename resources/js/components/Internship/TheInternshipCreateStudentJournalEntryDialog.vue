<template>
    <v-dialog v-model="dialog" max-width="500">
        <template v-slot:activator="{ on, attrs }">
            <v-card
                class="pa-3 mb-3 text-center"
                color="cardBackground"
                v-bind="attrs"
                elevation="0"
                v-on="on"
                ripple
            >
                <v-icon>mdi-plus</v-icon>
            </v-card>
        </template>
        <v-card color="cardBackground">

        </v-card>
    </v-dialog>
</template>

<script>
    import InternshipDialogActivator from "../_Helpers/InternshipDialogActivator";

    export default {
        name: "TheInternshipCreateStudentJournalEntryDialog",
        components: {InternshipDialogActivator},

        data() {
            return {
                dialog: false,
            }
        }
    }
</script>

<style scoped>

</style>
