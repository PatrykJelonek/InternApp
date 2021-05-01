<template>
    <v-dialog
        v-model="createAgreementDialog"
        persistent
        max-width="1000px"
        :fullscreen="this.$vuetify.breakpoint.smAndDown"
    >
        <expand-card
            title="Dodaj umowę"
            :description="`Wypełnij poniższy formularz by złożyć umowę firmie ${offer.company.name}`"
            :expand="false"
        >
            <template slot="buttons">
                <v-tooltip top>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            small
                            icon
                            v-bind="attrs"
                            v-on="on"
                            @click="toggleCreateAgreementDialog(false)">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </template>
                    <span>Zamknij</span>
                </v-tooltip>
            </template>
            <v-row class="pa-5">
                <v-col cols="12">
                    <create-agreement-form :offer="offer"></create-agreement-form>
                </v-col>
            </v-row>
        </expand-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../_Helpers/ExpandCard";
import CreateAgreementForm from "./CreateAgreementForm";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "CreateAgreementDialog",
    props: ['offer'],
    components: {CreateAgreementForm, ExpandCard},

    computed: {
        ...mapGetters({
            createAgreementDialog: 'helpers/createAgreementDialog',
        }),
    },

    methods: {
        ...mapActions({
            toggleCreateAgreementDialog: 'helpers/toggleCreateAgreementDialog',
        }),
    }
}
</script>

<style scoped>

</style>
