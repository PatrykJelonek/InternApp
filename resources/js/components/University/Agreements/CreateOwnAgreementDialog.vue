<template>
    <v-dialog
        v-model="dialogs['DIALOG_FIELD_CREATE_OWN_AGREEMENT']"
        persistent
        max-width="800px"
        @click:outside="closeDialog"
        :fullscreen="this.$vuetify.breakpoint.smAndDown"
    >
        <custom-card :loading="createOwnAgreementLoading">
            <custom-card-title>
                <template v-slot:default>Dodaj umowę</template>
                <template v-slot:subheader>Formularz dodawania umowy własnej</template>
                <template v-slot:actions>
                    <v-btn
                        small
                        icon
                        @click="closeDialog">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>

            <v-row no-gutters>
                <v-col cols="12">
                    <create-own-agreement-form :step="step"></create-own-agreement-form>
                </v-col>
            </v-row>
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
            dialogs: 'helpers/dialogs',
            createOwnAgreementStepper: 'helpers/createOwnAgreementStepper',
            createOwnAgreementLoading: 'helpers/createOwnAgreementLoading'
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog',
            fetchCompanies: 'company/fetchCompanies',
            setCreateOwnAgreementStepper: 'helpers/setCreateOwnAgreementStepper',
        }),

        closeDialog() {
            this.toggleDialog({key: 'DIALOG_FIELD_CREATE_OWN_AGREEMENT', val: false});
        }
    },
}
</script>

<style scoped>

</style>
