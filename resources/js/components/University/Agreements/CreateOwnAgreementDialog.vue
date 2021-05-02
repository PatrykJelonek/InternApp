<template>
    <v-dialog
        v-model="createOwnAgreementDialog"
        persistent
        max-width="1000px"
        :fullscreen="this.$vuetify.breakpoint.smAndDown"
    >
        <expand-card
            title="Dodaj umowę"
            description="Formularz dodawania własnej umowy."
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
                            @click="toggleCreateOwnAgreementDialog(false)">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </template>
                    <span>Zamknij</span>
                </v-tooltip>
            </template>
            <v-row class="pa-5">
                <v-col cols="12">
                    <create-own-agreement-form></create-own-agreement-form>
                </v-col>
            </v-row>
        </expand-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import CreateOwnAgreementForm from "./CreateOwnAgreementForm";
export default {
    name: "CreateOwnAgreementDialog",
    components: {CreateOwnAgreementForm, ExpandCard},

    computed: {
        ...mapGetters({
            createOwnAgreementDialog: 'helpers/createOwnAgreementDialog',
        }),
    },

    methods: {
        ...mapActions({
            toggleCreateOwnAgreementDialog: 'helpers/toggleCreateOwnAgreementDialog',
        }),
    }
}
</script>

<style scoped>

</style>
