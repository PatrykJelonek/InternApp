<template>
    <v-dialog
        v-model="createOwnAgreementDialog"
        persistent
        max-width="800px"
        :fullscreen="this.$vuetify.breakpoint.smAndDown"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Dodaj umowę</template>
                <template v-slot:subheader>Formularz dodawania umowy własnej</template>
                <template v-slot:actions>
                    <v-btn
                        small
                        icon
                        @click="toggleCreateOwnAgreementDialog(false)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>

            <v-row no-gutters>
                <v-col cols="12">
                    <create-own-agreement-form :step="step"></create-own-agreement-form>
                </v-col>
            </v-row>

            <custom-card-footer>
                <template v-slot:left>
                    <v-btn outlined color="secondary" @click="setCreateOwnAgreementStepper(createOwnAgreementStepper - 1);">
                        Cofnij
                    </v-btn>
                </template>
                <template v-slot:right>
                    <v-btn outlined color="primary" @click="setCreateOwnAgreementStepper(createOwnAgreementStepper + 1);">
                        Dalej
                    </v-btn>
                </template>
            </custom-card-footer>
        </custom-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import CreateOwnAgreementForm from "./CreateOwnAgreementForm";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import CustomCardFooter from "../../_General/CustomCardFooter";

export default {
    name: "CreateOwnAgreementDialog",
    components: {CustomCardFooter, CustomCardTitle, CustomCard, CreateOwnAgreementForm, ExpandCard},

    data() {
        return {
            step: 1,
        }
    },

    computed: {
        ...mapGetters({
            createOwnAgreementDialog: 'helpers/createOwnAgreementDialog',
            createOwnAgreementStepper: 'helpers/createOwnAgreementStepper',
        }),
    },

    methods: {
        ...mapActions({
            toggleCreateOwnAgreementDialog: 'helpers/toggleCreateOwnAgreementDialog',
            fetchCompanies: 'company/fetchCompanies',
            setCreateOwnAgreementStepper: 'helpers/setCreateOwnAgreementStepper',
        }),
    },
}
</script>

<style scoped>

</style>
