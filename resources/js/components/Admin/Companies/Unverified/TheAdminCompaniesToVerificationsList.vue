<template>
    <v-row no-gutters>
        <v-col cols="12">
            <custom-confirm-dialog
                title="Potwierdź"
                :confirm-function="verify"
                dialog-key="DIALOG_FIELD_VERIFY_COMPANY"
                :dialog-state="dialogs['DIALOG_FIELD_VERIFY_COMPANY']"
                :toggle-function="toggleDialog"
                :confirm-function-args="dialogArgs['DIALOG_FIELD_VERIFY_COMPANY']"
            >
                Potwierdzasz weryfikacje firmy?
            </custom-confirm-dialog>
            <custom-confirm-dialog
                title="Odrzuć uczelnie"
                subheader="Czy na pewno chcesz odrzucić tą firmę?"
                :confirm-function="reject"
                dialog-key="DIALOG_FIELD_REJECT_COMPANY"
                :dialog-state="dialogs['DIALOG_FIELD_REJECT_COMPANY']"
                :toggle-function="toggleDialog"
                :confirm-function-args="dialogArgs['DIALOG_FIELD_REJECT_COMPANY']"
            >
                <v-textarea
                    outlined
                    v-model="reason"
                    label="Powód odrzucenia"
                ></v-textarea>
            </custom-confirm-dialog>

            <v-data-table
                :headers="headers"
                :items="companiesToVerification"
                class="elevation-0 component-background"
                no-data-text="Wszystkie firmy zostały zweryfikowane!"
                no-results-text="Niestety, nie znaleziono szukanej firmy!"
                loading-text="Pobieranie listy firm do weryfikacji..."
                :search="search"
                :loading="companiesToVerificationLoading"
            >
                <template v-slot:item.actions="{ item }">
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                icon
                                v-bind="attrs"
                                v-on="on"
                            >
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                        <v-list dense class="cursor-pointer">
                            <v-list-item>
                                <v-list-item-title
                                    @click.stop="openVerifyUniversityDialog(item)"
                                    class="link"
                                >
                                    Weryfikuj
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-title
                                    @click.stop="openRejectUniversityDialog(item)"
                                    class="link"
                                >
                                    Odrzuć
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </template>
            </v-data-table>
        </v-col>
    </v-row>
</template>

<script>
import CustomCard from "../../../_General/CustomCard";
import {mapActions, mapGetters} from "vuex";
import CustomConfirmDialog from "../../../_General/CustomConfirmDialog";

export default {
    name: "TheAdminCompaniesToVerificationsList",
    components: {CustomConfirmDialog, CustomCard},

    props: ['search'],

    data() {
        return {
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Typ', value: 'type.name'},
                {text: 'Adres', value: 'full_address'},
                {text: 'Email', value: 'email'},
                {text: 'Akcje', value: 'actions'},
            ],
            selectedUniversity: null,
            reason: null,
        }
    },

    computed: {
        ...mapGetters({
            dialogs: 'helpers/dialogs',
            dialogArgs: 'helpers/dialogsArgs',
            companiesToVerification: 'company/companiesToVerification',
            companiesToVerificationLoading: 'company/companiesToVerificationLoading',
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog',
            setDialogArgs: 'helpers/setDialogArgs',
            fetchCompaniesToVerification: 'company/fetchCompaniesToVerification',
            verifyCompany: 'university/verifyUniversity',
            rejectCompany: 'university/rejectUniversity',
            setSnackbar: 'snackbar/setSnackbar',
        }),

        openVerifyUniversityDialog(university) {
            this.toggleDialog({key: 'DIALOG_FIELD_VERIFY_COMPANY', val: true});
            this.setDialogArgs({key:  'DIALOG_FIELD_VERIFY_COMPANY', val: [university]});
        },

        openRejectUniversityDialog(university) {
            this.toggleDialog({key: 'DIALOG_FIELD_REJECT_COMPANY', val: true});
            this.setDialogArgs({key:  'DIALOG_FIELD_REJECT_COMPANY', val: [university, this.reason]});
        },

        async verify() {
            let slug = this.dialogArgs['DIALOG_FIELD_VERIFY_COMPANY'][0].slug;

            await this.verifyUniversity({slug: slug}).then(() => {
                this.setSnackbar({message: 'Firma została zweryfikowana!', color: 'success'});
                this.fetchCompaniesToVerification();
            }).catch((e) => {
                console.log(e);
                this.setSnackbar({message: 'Ups, coś poszło nie tak!', color: 'error'});
            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_VERIFY_COMPANY', val: false});
                this.setDialogArgs({key:  'DIALOG_FIELD_VERIFY_COMPANY', val: []});
            });
        },

        async reject() {
            let slug = this.dialogArgs['DIALOG_FIELD_REJECT_COMPANY'][0].slug;

            await this.rejectUniversity({slug: slug, reason: this.reason}).then(() => {
                this.setSnackbar({message: 'Firma została odrzucona!', color: 'success'});
                this.fetchCompaniesToVerification();
            }).catch((e) => {
                console.log(e);
                this.setSnackbar({message: 'Ups, coś poszło nie tak!', color: 'error'});
            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_REJECT_COMPANY', val: false});
                this.setDialogArgs({key:  'DIALOG_FIELD_REJECT_COMPANY', val: []});
            });
        },
    },

    created() {
        this.fetchCompaniesToVerification().then(() => {

        }).catch((e) => {

        })
    }
}
</script>

<style scoped>

</style>
