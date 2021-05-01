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
            <create-internship-form></create-internship-form>
        </expand-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";
import CreateInternshipForm from "./CreateInternshipForm";

export default {
    name: "CreateInternshipDialog",
    components: {
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
