<template>
    <v-container fluid class="pa-0">
        <page-title>
            Pracownicy
            <template v-slot:subheader>Lista pracowników {{ company.name }}</template>
        </page-title>
        <custom-confirm-dialog
            title="Aktywuj pracownika"
            subheader="Czy na pewno chcesz aktywować tego pracownika?"
            :dialog-state="dialogs['DIALOG_FIELD_ACTIVATE_COMPANY_WORKER']"
            :toggle-function="toggleDialog"
            :confirm-function="activate"
            dialog-key="DIALOG_FIELD_DEACTIVATE_COMPANY_WORKER"
        ></custom-confirm-dialog>
        <custom-confirm-dialog
            title="Dezaktywuj pracownika"
            subheader="Czy na pewno chcesz dezaktywować tego pracownika?"
            :dialog-state="dialogs['DIALOG_FIELD_DEACTIVATE_COMPANY_WORKER']"
            :toggle-function="toggleDialog"
            :confirm-function="deactivate"
            dialog-key="DIALOG_FIELD_DEACTIVATE_COMPANY_WORKER"
        ></custom-confirm-dialog>
        <custom-confirm-dialog
            :dialog-state="deleteCompanyWorkerDialog"
            :toggle-function="toggleDeleteCompanyWorkerDialog"
            :confirm-function="deleteWorker"
            :confirm-function-args="[selectedWorkerId]"
            title="Usuń pracownika"
            subheader="Czy chcesz usunąć tego pracownika z firmy?"
        ></custom-confirm-dialog>
        <custom-confirm-dialog
            :dialog-state="acceptCompanyWorkerDialog"
            :toggle-function="toggleAcceptCompanyWorkerDialog"
            :confirm-function="acceptWorker"
            :confirm-function-args="[selectedWorkerId]"
            title="Akceptuj pracownika"
            subheader="Czy chcesz zaakceptować tego pracownika jako pracownika firmy?"
        ></custom-confirm-dialog>
        <select-roles-dialog
            :groups="['company']"
            :submit-function="changeRoles"
            :existent-roles-id="selectedWorkerRolesIds"
        ></select-roles-dialog>

        <v-row no-gutters>
            <v-col cols="12">
                <custom-card>
                    <v-text-field
                        v-model="search"
                        outlined
                        prepend-inner-icon="mdi-magnify"
                        label="Szukaj"
                        hide-details
                    ></v-text-field>
                </custom-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <custom-card>
                    <custom-card-title>
                        <template v-slot:default>Lista pracowników</template>
                    </custom-card-title>
                    <v-data-table
                        :items="companyWorkers"
                        :headers="headers"
                        class="component-background"
                        :loading="companyWorkersLoading"
                        :search="search"
                    >
                        <template v-slot:item.full_name="{item}">
                            <v-avatar :size="30" rounded class="mr-2" :color="item.avatar_url ? '' : 'primary'">
                                <v-img :src="item.avatar_url ? '/'+item.avatar_url : ''"
                                       :alt="'Awatar użytkownika ' + item.full_name"></v-img>
                            </v-avatar>
                            {{ item.full_name }}
                        </template>
                        <template v-slot:item.status="{item}">
                            <v-chip outlined small :color="item.status.name === 'active' ? 'primary' : ''">
                                {{ item.status.description }}
                            </v-chip>
                        </template>
                        <template v-slot:item.verified="{ item }">
                            <template v-if="item.companies_with_roles[0].verified">
                                <v-icon color="primary" small class="mr-2">mdi-check-decagram-outline</v-icon>
                                Tak
                            </template>
                            <template v-else>
                                <v-icon color="secondary" small class="mr-2">mdi-alert-decagram-outline</v-icon>
                                Nie
                            </template>
                        </template>
                        <template v-slot:item.active="{ item }">
                            <template v-if="item.companies_with_roles[0].active">
                                <v-icon color="primary" small class="mr-2">mdi-check-decagram-outline</v-icon>
                                Tak
                            </template>
                            <template v-else>
                                <v-icon color="secondary" small class="mr-2">mdi-alert-decagram-outline</v-icon>
                                Nie
                            </template>
                        </template>
                        <template v-slot:item.roles="{item}">
                            <v-chip-group v-if="item.companies_with_roles[0].roles.length > 0">
                                <v-chip
                                    outlined small v-for="role in item.companies_with_roles[0].roles"
                                    :key="role.id"
                                >
                                    {{ role.display_name }}
                                </v-chip>
                            </v-chip-group>
                            <template v-else>
                                <span class="secondary--text">---</span>
                            </template>
                        </template>
                        <template v-slot:item.actions="{item}">
                            <v-menu offset-y>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        v-bind="attrs"
                                        v-on="on"
                                        icon
                                    >
                                        <v-icon>mdi-dots-vertical</v-icon>
                                    </v-btn>
                                </template>
                                <v-list dense class="component-background lighten-1 cursor-pointer">
                                    <template v-if="!item.companies_with_roles[0].verified">
                                        <v-list-item
                                            class="cursor-pointer"
                                            @mouseup="selectedWorkerFullName = item.full_name; selectedWorkerId = item.id"
                                            @click="toggleAcceptCompanyWorkerDialog(true)"
                                            v-has-company-role="['company_owner', 'company_manager']"
                                        >
                                            <v-list-item-content>
                                                <v-list-item-title>Akceptuj pracownika</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item
                                            class="cursor-pointer"
                                            @mouseup="selectedWorkerFullName = item.full_name; selectedWorkerId = item.id"
                                            @click="toggleDeleteCompanyWorkerDialog(true)"
                                            v-has-company-role="['company_owner', 'company_manager']"
                                        >
                                            <v-list-item-content>
                                                <v-list-item-title>Odrzuć pracownika</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </template>
                                    <template v-else>
                                        <v-list-item :to="{name: 'user', params: {id: item.id}}">
                                            <v-list-item-content>
                                                <v-list-item-title>Wyświetl profil</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item v-has-company-role="['company_owner', 'company_manager']">
                                            <v-list-item-content @click="openChangeRoleDialog(item)">
                                                <v-list-item-title>Zmień rolę</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item
                                            v-if="!item.companies_with_roles[0].active && hasCompanyRole(['company_owner', 'company_manager']) && item.id !== user.id"
                                            @click="openActivateDialog(item)"
                                        >
                                            <v-list-item-content>
                                                <v-list-item-title>Aktywuj</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item
                                            v-else-if="item.companies_with_roles[0].active && hasCompanyRole(['company_owner', 'company_manager']) && item.id !== user.id"
                                            @click="openDeactivateDialog(item)"
                                        >
                                            <v-list-item-content>
                                                <v-list-item-title>Dezaktywuj</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </template>
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
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";
import CustomConfirmDialog from "../../_General/CustomConfirmDialog";
import CustomCardTitle from "../../_General/CustomCardTitle";
import {hasCompanyRole} from "../../../plugins/acl";
import SelectRolesDialog from "../../Roles/SelectRolesDialog";

export default {
    name: "TheCompanyWorkers",
    components: {SelectRolesDialog, CustomCardTitle, CustomConfirmDialog, CustomCard, PageTitle},

    data() {
        return {
            search: null,
            selectedWorker: null,
            selectedWorkerId: null,
            selectedWorkerFullName: null,
            selectedWorkerRolesIds: [],
            headers: [
                {text: "Imie i nazwisko", value: 'full_name', align: 'left'},
                {text: "Role", value: 'roles', align: 'left'},
                {text: 'Zweryfikowany', value: 'verified', sortable: false, align: 'center'},
                {text: 'Aktywny', value: 'active', sortable: false, align: 'center'},
                {text: "Akcje", value: 'actions', sortable: false}
            ],
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            dialogs: 'helpers/dialogs',
            dialogsArgs: 'helpers/dialogsArgs',
            company: 'company/company',
            companyWorkers: 'company/companyWorkers',
            companyWorkersLoading: 'company/companyWorkersLoading',
            deleteCompanyWorkerDialog: 'helpers/deleteCompanyWorkerDialog',
            acceptCompanyWorkerDialog: 'helpers/acceptCompanyWorkerDialog',
        })
    },

    methods: {
        hasCompanyRole,

        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            fetchCompanyWorkers: 'company/fetchCompanyWorkers',
            changeCompanyWorkerRoles: 'company/changeCompanyWorkerRoles',
            toggleDeleteCompanyWorkerDialog: 'helpers/toggleDeleteCompanyWorkerDialog',
            toggleAcceptCompanyWorkerDialog: 'helpers/toggleAcceptCompanyWorkerDialog',
            acceptCompanyWorker: 'company/acceptCompanyWorker',
            deleteCompanyWorker: 'company/deleteCompanyWorker',
            setSnackbar: 'snackbar/setSnackbar',
            toggleDialog: 'helpers/toggleDialog',
            setDialogArgs: 'helpers/setDialogArgs',
            activeCompanyWorker: 'company/activeCompanyWorker',
            deactivateCompanyWorker: 'company/deactivateCompanyWorker'
        }),

        deleteWorker(userId) {
            this.deleteCompanyWorker({slug: this.$route.params.slug, userId: userId}).then((response) => {
                this.toggleDeleteCompanyWorkerDialog(false);
                this.fetchCompanyWorkers(this.$route.params.slug);
                this.setSnackbar({message: 'Użytkownik został usunięty z listy pracowników!', color: 'success'});
            }).catch((e) => {
                this.toggleDeleteCompanyWorkerDialog(false);
                this.setSnackbar({
                    message: 'Wystąpił problem z usunięciem użytkownika z listy pracowników!',
                    color: 'error'
                });
            });

        },

        acceptWorker(userId) {
            this.acceptCompanyWorker({slug: this.$route.params.slug, userId: userId}).then((response) => {
                this.setSnackbar({
                    message: 'Użytkownik został zaakceptowany jako pracownik tej firmy!',
                    color: 'success'
                });
                this.toggleAcceptCompanyWorkerDialog(false);
                this.fetchCompanyWorkers(this.$route.params.slug);
            }).catch((e) => {
                this.setSnackbar({
                    message: 'Wystąpił problem podczas akceptacji użytkownika jako pracownika tej firmy',
                    color: 'error'
                });
                this.toggleAcceptCompanyWorkerDialog(false);
            });
        },

        openChangeRoleDialog(item) {
            this.selectedItem = item;
            this.selectedWorkerRolesIds = item.companies_with_roles[0].roles.map((role) => {
                return role.id;
            });
            this.toggleDialog({key: 'DIALOG_FIELD_SELECT_ROLES', val: true});
        },

        changeRoles(rolesIds) {
            this.changeCompanyWorkerRoles({
                slug: this.$route.params.slug,
                userId: this.selectedItem.id,
                userCompanyId: this.selectedItem.companies_with_roles[0].id,
                rolesIds: rolesIds
            }).then((response) => {
                this.setSnackbar({message: 'Role zostały zmienione!', color: 'success'});
                this.fetchCompanyWorkers(this.$route.params.slug);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się zmienić ról!', color: 'error'});
            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_SELECT_ROLES', val: false});
            });
        },

        openActivateDialog(item) {
            this.setDialogArgs({
                key: 'DIALOG_FIELD_ACTIVATE_COMPANY_WORKER', val: {
                    userId: item.id
                }
            });
            this.toggleDialog({key: 'DIALOG_FIELD_ACTIVATE_COMPANY_WORKER', val: true});
        },

        openDeactivateDialog(item) {
            this.setDialogArgs({
                key: 'DIALOG_FIELD_DEACTIVATE_COMPANY_WORKER', val: {
                    userId: item.id
                }
            });
            this.toggleDialog({key: 'DIALOG_FIELD_DEACTIVATE_COMPANY_WORKER', val: true});
        },

        async activate() {
            await this.activeCompanyWorker({
                slug: this.$route.params.slug,
                userId: this.dialogsArgs.DIALOG_FIELD_ACTIVATE_COMPANY_WORKER.userId,
            }).then(() => {
                this.setSnackbar({message: 'Pracownik został aktywowany!', color: 'success'});
                this.fetchCompanyWorkers(this.$route.params.slug);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się aktywować pracownika!', color: 'error'});
            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_ACTIVATE_COMPANY_WORKER', val: false});
            });
        },

        async deactivate() {
            await this.deactivateCompanyWorker({
                slug: this.$route.params.slug,
                userId: this.dialogsArgs.DIALOG_FIELD_DEACTIVATE_COMPANY_WORKER.userId,
            }).then(() => {
                this.setSnackbar({message: 'Pracownik został dezaktywowany!', color: 'success'});
                this.fetchCompanyWorkers(this.$route.params.slug);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się dezaktywować pracownika!', color: 'error'});
            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_DEACTIVATE_COMPANY_WORKER', val: false});
            });
        }
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {
                text: this.company.name ?? 'Firma',
                to: {name: 'company', params: {slug: this.$route.params.slug}},
                exact: true
            },
            {text: 'Pracownicy', to: {name: 'company-workers'}, exact: true},
        ]);

        this.fetchCompanyWorkers(this.$route.params.slug).then((response) => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
