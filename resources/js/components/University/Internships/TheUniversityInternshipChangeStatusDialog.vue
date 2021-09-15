<template>
    <v-dialog
        v-model="dialogs['DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS']"
        class="component-background"
        persistent
        max-width="600"
        v-if="dialogsArgs['DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS'] !== null"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Zmień status</template>
                <template v-slot:subheader>Zmień status dla praktyki {{ dialogsArgs['DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS'].name }}</template>
            </custom-card-title>
            <v-row no-gutters>
                <v-col cols="12" class="pa-5">
                    <v-select
                        label="Status"
                        v-model="selectedStatus"
                        :items="internshipStatuses"
                        item-text="display_name"
                        item-value="id"
                        :loading="internshipStatusesLoading"
                        outlined
                        dense
                        hide-details="auto"
                        background-color="component-background"
                        class="component-background"
                    ></v-select>
                </v-col>
            </v-row>
            <v-row no-gutters>
                <v-col cols="12">
                    <v-divider></v-divider>
                </v-col>
            </v-row>
            <v-row no-gutters>
                <v-col cols="12" class="d-flex justify-space-between px-5 py-2">
                    <v-btn text color="secondary" @click="closeDialog">Anuluj</v-btn>
                    <v-btn
                        outlined
                        color="primary"
                        @click="changeStatus"
                        :disabled="!hasUniversityRole(['deanery_worker','university_owner']) && selectedStatus"
                    >
                        Zapisz
                    </v-btn>
                </v-col>
            </v-row>
        </custom-card>
    </v-dialog>
</template>

<script>
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import {mapActions, mapGetters, mapState} from "vuex";
import {hasUniversityRole} from "../../../plugins/acl";

export default {
    name: "TheUniversityInternshipChangeStatusDialog",
    components: {CustomCardTitle, CustomCard},

    data() {
        return {
            selectedStatus: null,
        }
    },

    computed: {
        ...mapState({
            dialogsState: 'helpers/dialogs',
        }),

        ...mapGetters({
            internshipStatuses: 'internship/internshipStatuses',
            internshipStatusesLoading: 'internship/internshipStatusesLoading',
            dialogs: 'helpers/dialogs',
            dialogsArgs: 'helpers/dialogsArgs'
        }),
    },

    methods: {
        hasUniversityRole,

        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchInternshipStatuses: 'internship/fetchInternshipStatuses',
            toggleDialog: 'helpers/toggleDialog',
            changeInternshipStatus: 'internship/changeInternshipStatus',
            setDialogArgs: 'helpers/setDialogArgs',
        }),

        changeStatus() {
            this.changeInternshipStatus({
                internshipId: this.dialogsArgs['DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS'].id,
                statusId: this.selectedStatus,
            }).then((response) => {
                this.$store.commit('university/CHANGE_UNIVERSITY_INTERNSHIP_STATUS', {
                    id: response.data.id,
                    status: this.internshipStatuses.find(status => status.id === response.data.internship_status_id).display_name,
                    hexColor: this.internshipStatuses.find(status => status.id === response.data.internship_status_id).hex_color,
                })
                this.setSnackbar({message: 'Status został zmieniony!', color: 'success'});
                this.toggleDialog({key: 'DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS', val: false});
                this.setDialogArgs({key: 'DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS', val: null});
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się zmienić statusu!', color: 'error'});
                this.toggleDialog({key: 'DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS', val: false});
                this.setDialogArgs({key: 'DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS', val: null});
            });
        },

        closeDialog() {
            this.toggleDialog({key: 'DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS', val: false});
            this.setDialogArgs({key: 'DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS', val: null});
            this.selectedStatus = null;
        }
    },

    created() {
        this.fetchInternshipStatuses().then((response) => {

        }).catch((e) => {
            this.setSnackbar({message: 'Wystąpił problem z pobraniem listy statusów!', color: 'error'});
            this.toggleDialog({key: 'DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS', val: false});
        });
    },
}
</script>

<style scoped>

</style>
