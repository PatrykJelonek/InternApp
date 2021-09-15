<template>
    <v-row no-gutters>
        <v-col cols="12">
            <custom-confirm-dialog
                title="Potwierdź"
                :confirm-function="verify"
                dialog-key="DIALOG_FIELD_VERIFY_UNIVERSITY"
                :dialog-state="dialogs['DIALOG_FIELD_VERIFY_UNIVERSITY']"
                :toggle-function="toggleDialog"
                :confirm-function-args="dialogArgs['DIALOG_FIELD_VERIFY_UNIVERSITY']"
            >
                Potwierdzasz weryfikacje uczelni?
            </custom-confirm-dialog>
            <custom-confirm-dialog
                title="Odrzuć uczelnie"
                subheader="Czy na pewno chcesz odrzucić tą uczelnie?"
                :confirm-function="reject"
                dialog-key="DIALOG_FIELD_REJECT_UNIVERSITY"
                :dialog-state="dialogs['DIALOG_FIELD_REJECT_UNIVERSITY']"
                :toggle-function="toggleDialog"
                :confirm-function-args="dialogArgs['DIALOG_FIELD_REJECT_UNIVERSITY']"
            >
                <v-textarea
                    outlined
                    v-model="reason"
                    label="Powód odrzucenia"
                ></v-textarea>
            </custom-confirm-dialog>
            <v-data-table
                :headers="headers"
                :items="universitiesToVerification"
                class="elevation-0 component-background"
                no-data-text="Wszystkie uczelnie zostały zweryfikowane!"
                no-results-text="Niestety, nie znaleziono szukanej uczelni!"
                loading-text="Pobieranie listy uczelni do weryfikacji..."
                :search="search"
                :loading="universitiesToVerificationLoading"
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
import {mapActions, mapGetters} from "vuex";
import CustomConfirmDialog from "../../../_General/CustomConfirmDialog";

export default {
    name: "TheAdminUniversitiesToVerificationList",
    components: {CustomConfirmDialog},
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
            universitiesToVerification: 'university/universitiesToVerification',
            universitiesToVerificationLoading: 'university/universitiesToVerificationLoading',
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog',
            setDialogArgs: 'helpers/setDialogArgs',
            fetchUniversitiesToVerification: 'university/fetchUniversitiesToVerification',
            verifyUniversity: 'university/verifyUniversity',
            rejectUniversity: 'university/rejectUniversity',
            setSnackbar: 'snackbar/setSnackbar',
        }),

        openVerifyUniversityDialog(university) {
            this.toggleDialog({key: 'DIALOG_FIELD_VERIFY_UNIVERSITY', val: true});
            this.setDialogArgs({key:  'DIALOG_FIELD_VERIFY_UNIVERSITY', val: [university]});
        },

        openRejectUniversityDialog(university) {
            this.toggleDialog({key: 'DIALOG_FIELD_REJECT_UNIVERSITY', val: true});
            this.setDialogArgs({key:  'DIALOG_FIELD_REJECT_UNIVERSITY', val: [university, this.reason]});
        },

       async verify() {
           let slug = this.dialogArgs['DIALOG_FIELD_VERIFY_UNIVERSITY'][0].slug;

           await this.verifyUniversity({slug: slug}).then(() => {
                this.setSnackbar({message: 'Uczelnia została zweryfikowana!', color: 'success'});
                this.fetchUniversitiesToVerification();
           }).catch((e) => {
               this.setSnackbar({message: 'Ups, coś poszło nie tak!', color: 'error'});
           }).finally(() => {
               this.toggleDialog({key: 'DIALOG_FIELD_VERIFY_UNIVERSITY', val: false});
               this.setDialogArgs({key:  'DIALOG_FIELD_VERIFY_UNIVERSITY', val: []});
           });
        },

        async reject() {
            let slug = this.dialogArgs['DIALOG_FIELD_REJECT_UNIVERSITY'][0].slug;

            await this.rejectUniversity({slug: slug, reason: this.reason}).then(() => {
                this.setSnackbar({message: 'Uczelnia została odrzucona!', color: 'success'});
                this.fetchUniversitiesToVerification();
            }).catch((e) => {
                this.setSnackbar({message: 'Ups, coś poszło nie tak!', color: 'error'});
            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_REJECT_UNIVERSITY', val: false});
                this.setDialogArgs({key:  'DIALOG_FIELD_REJECT_UNIVERSITY', val: []});
            });
        },
    },

    created() {
        this.fetchUniversitiesToVerification().then(() => {

        }).catch((e) => {

        })
    }
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
