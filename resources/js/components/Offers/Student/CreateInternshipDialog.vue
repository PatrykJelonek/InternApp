<template>
    <v-dialog
        v-model="dialog"
        persistent
        max-width="800px"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Dodaj Praktykę</template>
                <template v-slot:subheader>Formularz dodawania nowej praktyki.</template>
                <template v-slot:actions>
                    <v-btn
                        icon
                        @click="toggleDialog(false)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>
            <create-internship-form></create-internship-form>
        </custom-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";
import CreateInternshipForm from "./CreateInternshipForm";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "CreateInternshipDialog",
    components: {
        CustomCardTitle,
        CustomCard,
        CreateInternshipForm,
        ExpandCard,
    },

    data() {
        return {}
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
    }
}
</script>

<style scoped>

</style>
