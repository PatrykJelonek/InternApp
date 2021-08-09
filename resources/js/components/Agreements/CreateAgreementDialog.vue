<template>
    <v-dialog
        v-model="dialogs['DIALOG_FIELD_CREATE_AGREEMENT_FROM_OFFER']"
        persistent
        max-width="1000px"
        :fullscreen="this.$vuetify.breakpoint.smAndDown"
        v-if="dialogsArgs['DIALOG_FIELD_CREATE_AGREEMENT_FROM_OFFER']"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Dodaj umowę</template>
                <template v-slot:subheader>Wypełnij poniższy formularz by złożyć umowę firmie {{ dialogsArgs['DIALOG_FIELD_CREATE_AGREEMENT_FROM_OFFER'].company.name }}</template>
                <template v-slot:actions>
                    <v-btn
                        icon
                        @click="toggleDialog({key: 'DIALOG_FIELD_CREATE_AGREEMENT_FROM_OFFER', val: false})"
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>
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
                    <create-agreement-form :offer="dialogsArgs['DIALOG_FIELD_CREATE_AGREEMENT_FROM_OFFER']"></create-agreement-form>
                </v-col>
            </v-row>
        </custom-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../_Helpers/ExpandCard";
import CreateAgreementForm from "./CreateAgreementForm";
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";

export default {
    name: "CreateAgreementDialog",
    props: ['offer'],
    components: {CustomCardTitle, CustomCard, CreateAgreementForm, ExpandCard},

    computed: {
        ...mapGetters({
            dialogs: 'helpers/dialogs',
            createAgreementDialog: 'helpers/createAgreementDialog',
            dialogsArgs: 'helpers/dialogsArgs'
        }),
    },

    methods: {
        ...mapActions({
            toggleCreateAgreementDialog: 'helpers/toggleCreateAgreementDialog',
            toggleDialog: 'helpers/toggleDialog'
        }),
    }
}
</script>

<style scoped>

</style>
