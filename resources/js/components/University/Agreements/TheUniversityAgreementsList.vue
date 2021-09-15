<template>
    <v-container fluid class="pa-0">
        <custom-confirm-dialog
            title="Dezaktywuj umowę"
            description="Czy na pewno chcesz dezaktywować tą umowę?"
            :dialog-state="dialogs['DIALOG_FIELD_DEACTIVATE_AGREEMENT']"
            :toggle-function="toggleDialog"
            :confirm-function="deactivate"
            dialog-key="DIALOG_FIELD_DEACTIVATE_AGREEMENT"
        ></custom-confirm-dialog>
        <custom-confirm-dialog
            title="Aktywuj umowę"
            description="Czy na pewno chcesz aktywować tą umowę?"
            :dialog-state="dialogs['DIALOG_FIELD_ACTIVATE_AGREEMENT']"
            :toggle-function="toggleDialog"
            :confirm-function="activate"
            dialog-key="DIALOG_FIELD_ACTIVATE_AGREEMENT"
        ></custom-confirm-dialog>
        <custom-confirm-dialog
            title="Usuń umowę"
            description="Czy na pewno chcesz usunąć tą umowę?"
            :dialog-state="dialogs['DIALOG_FIELD_DELETE_AGREEMENT']"
            :toggle-function="toggleDialog"
            :confirm-function="deleteAgreement"
            dialog-key="DIALOG_FIELD_DELETE_AGREEMENT"
        ></custom-confirm-dialog>
        <v-row>
            <v-col cols="12">
                <custom-card>
                    <custom-card-title>
                        <template v-slot:default>Lista umów</template>
                        <template v-slot:actions>
                            <v-tooltip top v-has-university-role="['deanery_worker','university_owner']">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        small
                                        icon
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="toggleCreateOwnAgreementDialog(true)"
                                    >
                                        <v-icon>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                <span>Dodaj Umowę</span>
                            </v-tooltip>
                        </template>
                    </custom-card-title>

                    <v-data-table
                        :headers="headers"
                        :items="agreements"
                        :items-per-page="5"
                        :search="search"
                        :loading="agreementsLoading"
                        class="component-background"
                        no-data-text="Niestety, ta uczelnia nie posiada jeszcze umów!"
                        loading-text="Pobieranie listy umów..."
                    >
                        <template v-slot:item.company.name="{ item }">
                            <router-link :to="{name: 'company', params: {slug: item.company.slug}}">{{
                                    item.company.draft ? item.company.draft_name : item.company.name
                                }}
                            </router-link>
                        </template>
                        <template v-slot:item.supervisor.full_name="{ item }">
                            <router-link :to="{name: 'user', params: {id: item.supervisor.id}}">
                                {{ item.supervisor.full_name }}
                            </router-link>
                        </template>
                        <template v-slot:item.offer.supervisor.full_name="{ item }">
                            <template v-if="item.offer">
                                <router-link :to="{name: 'user', params: {id: item.offer.supervisor.id}}">
                                    {{ item.offer.supervisor.full_name }}
                                </router-link>
                            </template>
                            <template v-else>
                                Brak
                            </template>
                        </template>
                        <template v-slot:item.dates="{ item }">
                            {{ item.date_from + ' - ' + item.date_to }}
                        </template>
                        <template v-slot:item.is_active="{ item }">
                            {{ item.is_active ? 'Tak' : 'Nie' }}
                        </template>
                        <template v-slot:item.status.display_name="{ item }">
                            <v-chip
                                small
                                outlined
                                :color="item.status.hex_color"
                            >
                                {{ item.status.display_name }}
                            </v-chip>
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-menu offset-y class="component-background" >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        icon
                                        v-bind="attrs"
                                        v-on="on"
                                        :disabled="!hasUniversityRole(['deanery_worker','university_owner'])"
                                    >
                                        <v-icon>mdi-dots-vertical</v-icon>
                                    </v-btn>
                                </template>
                                <v-list dense color="component-background">
                                    <v-list-item
                                        v-if="item.is_active"
                                        v-has-university-role="['deanery_worker','university_owner']"
                                    >
                                        <v-list-item-title
                                            class="link"
                                            @click="toggle('DIALOG_FIELD_DEACTIVATE_AGREEMENT', true, item)"
                                        >
                                            Dezaktywuj umowę
                                        </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item
                                        v-if="!item.is_active"
                                        v-has-university-role="['deanery_worker','university_owner']"
                                    >
                                        <v-list-item-title
                                            class="link"
                                            @click="toggle('DIALOG_FIELD_ACTIVATE_AGREEMENT', true, item)"
                                        >
                                            Aktywuj umowę
                                        </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item
                                        v-if="!item.deleted_at"
                                        v-has-university-role="['deanery_worker','university_owner']"
                                    >
                                        <v-list-item-title
                                            class="link"
                                            @click="toggle('DIALOG_FIELD_DELETE_AGREEMENT', true, item)"
                                        >
                                            Usuń umowę
                                        </v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </template>
                    </v-data-table>
                </custom-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import moment from "moment";
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";
import CreateOwnAgreementDialog from "./CreateOwnAgreementDialog";
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import CustomConfirmDialog from "../../_General/CustomConfirmDialog";
import {hasUniversityRole} from "../../../plugins/acl";

export default {
    name: "TheUniversityAgreementsList",
    components: {CustomConfirmDialog, CustomCardTitle, CustomCard, PageTitle, CreateOwnAgreementDialog, ExpandCard},
    props: ['search'],

    data() {
        return {
            show: true,
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Firma', value: 'company.name'},
                {text: 'Opiekun z uczelni', value: 'supervisor.full_name'},
                {text: 'Opiekun z firmy', value: 'offer.supervisor.full_name'},
                {text: 'Okres ważności', value: 'dates'},
                {text: 'Status', value: 'status.display_name'},
                {text: 'Aktywna', value: 'is_active'},
                {text: 'Akcje', value: 'actions', sortable: false, align: 'center'},
            ],
            dialogArgs: [],
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            universityLoading: 'university/universityLoading',
            agreements: 'university/agreements',
            agreementsLoading: 'university/agreementsLoading',
            dialogs: 'helpers/dialogs'
        }),
    },

    methods: {
        hasUniversityRole,

        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchAgreements: 'university/fetchAgreements',
            toggleCreateOwnAgreementDialog: 'helpers/toggleCreateOwnAgreementDialog',
            toggleDialog: 'helpers/toggleDialog',
            activateAgreement: 'agreement/activateAgreement',
            deactivateAgreement: 'agreement/deactivateAgreement',
            setUniversityAgreementActiveStatus: 'university/setUniversityAgreementActiveStatus',
            deleteUniversityAgreement: 'university/deleteUniversityAgreement',
            deleteAgreement: 'agreement/deleteAgreement'
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },

        toggle(key, val, args) {
            this.toggleDialog({
                key: key,
                val: val,
            });
            this.dialogArgs = args;
        },

        activate() {
            this.activateAgreement({slug: this.dialogArgs.slug}).then((res) => {
                this.setUniversityAgreementActiveStatus({slug: this.dialogArgs.slug, data: true});
                this.toggle('DIALOG_FIELD_ACTIVATE_AGREEMENT', false, null);
                this.setSnackbar({message: 'Umowa została aktywowana!', color: 'success'});
            }).catch((e) => {
                this.toggle('DIALOG_FIELD_ACTIVATE_AGREEMENT', false, null);
                this.setSnackbar({message: 'Nie udało się aktywować umowy!', color: 'error'});
            });
        },

        deactivate() {
            this.deactivateAgreement({slug: this.dialogArgs.slug}).then((res) => {
                this.setUniversityAgreementActiveStatus({slug: this.dialogArgs.slug, data: false});
                this.toggle('DIALOG_FIELD_DEACTIVATE_AGREEMENT', false, null);
                this.setSnackbar({message: 'Umowa została dezaktywowana!', color: 'success'});
            }).catch((e) => {
                this.toggle('DIALOG_FIELD_DEACTIVATE_AGREEMENT', false, null);
                this.setSnackbar({message: 'Nie udało się dezaktywować umowy!', color: 'error'});
            });
        },

        deleteAgreement() {
            this.deleteAgreement({slug: this.dialogArgs.slug}).then((res) => {
                this.deleteUniversityAgreement({slug: this.dialogArgs.slug});
                this.toggle('DIALOG_FIELD_DELETE_AGREEMENT', false, null);
                this.setSnackbar({message: 'Umowa została usunięta!', color: 'success'});
            }).catch((e) => {
                this.toggle('DIALOG_FIELD_DELETE_AGREEMENT', false, null);
                this.setSnackbar({message: 'Nie udało się usunąć umowy!', color: 'error'});
            });
        }
    },

    created() {
        this.fetchAgreements(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style lang="scss" scoped>

</style>
