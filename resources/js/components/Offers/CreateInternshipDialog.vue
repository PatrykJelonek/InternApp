<template>
    <v-dialog
        v-model="dialog"
        persistent
        max-width="800px"
    >
        <expand-card
            title="Dodaj Praktykę"
            description="Formularz dodawania nowej praktyki."
            :expand="false"
        >
            <validation-observer ref="observer" v-slot="{ validate }">
                <v-form class="pa-5">
                    <v-row>
                        <v-col cols="12">
                            <create-internship-form></create-internship-form>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-btn
                                outlined
                                color="primary"
                                @click.stop="submit"
                            >
                                Dodaj Praktykę
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </validation-observer>
        </expand-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import ExpandCard from "../_Helpers/ExpandCard";
import CreateInternshipForm from "./CreateInternshipForm";

setInteractionMode('eager');

export default {
    name: "CreateInternshipDialog",
    components: {
        CreateInternshipForm,
        ExpandCard,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            stepper: 1,
        }
    },

    computed: {
        ...mapGetters({
            dialog: 'helpers/createInternshipDialog',
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleCreateInternshipDialog',
        }),

        submit() {
            this.toggleDialog();
        }
    }
}
</script>

<style scoped>

</style>
