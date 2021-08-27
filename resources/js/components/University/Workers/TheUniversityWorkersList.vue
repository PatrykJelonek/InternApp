<template>
    <custom-card>
        <custom-confirm-dialog
            title="Zweryfikuj"
            :confirm-function="verifyWorker"
            :confirm-function-args="[]"
            dialog-key="DIALOG_FIELD_VERIFY_UNIVERSITY_WORKER"
            :dialog-state="dialogs['DIALOG_FIELD_VERIFY_UNIVERSITY_WORKER']"
            :toggle-function="toggleDialog"
        >
            Czy na pewno chcesz zweryfikować tego pracownika?
        </custom-confirm-dialog>
        <select-roles-dialog :groups="['university']" :submit-function="changeRoles"
                             :existent-roles-id="selectedWorkerRolesIds"></select-roles-dialog>
        <custom-card-title>
            <template v-slot:default>Lista pracowników</template>
        </custom-card-title>
        <v-row v-show="show" no-gutters>
            <v-col cols="12">
                <v-data-table
                    :headers="headers"
                    :items="workers"
                    :items-per-page="5"
                    :loading="workersLoading"
                    class="component-background"
                    no-data-text="Niestety, ta uczelnia nie posiada jeszcze pracowników!"
                    no-results-text="Niestety, nie znaleziono szukanego pracownika!"
                    loading-text="Pobieranie listy pracowników..."
                    :search="search"
                >
                    <template v-slot:item.full_name="{item}">
                        <v-avatar :size="30" rounded class="mr-2" :color="item.avatar_url ? '' : 'primary'">
                            <v-img :src="item.avatar_url ? '/'+item.avatar_url : ''"
                                   :alt="'Awatar użytkownika ' + item.full_name"></v-img>
                        </v-avatar>
                        {{ item.full_name }}
                    </template>
                    <template v-slot:item.rolesChips="{ item }">
                        <template v-if="item.universities_with_roles[0].roles.length > 0">
                            <v-chip-group>
                                <v-chip
                                    small
                                    outlined
                                    v-for="role in item.universities_with_roles[0].roles"
                                    :key="role.id"
                                >{{ role.display_name }}
                                </v-chip>
                            </v-chip-group>
                        </template>
                        <template v-else>
                            <span class="text-caption secondary--text">Brak</span>
                        </template>
                    </template>
                    <template v-slot:item.verified="{ item }">
                        <template v-if="item.universities_with_roles[0].verified">
                            <v-icon color="primary" small class="mr-2">mdi-check-decagram-outline</v-icon>
                            Tak
                        </template>
                        <template v-else>
                            <v-icon color="secondary" small class="mr-2">mdi-alert-decagram-outline</v-icon>
                            Nie
                        </template>
                    </template>
                    <template v-slot:item.active="{ item }">
                        <template v-if="item.universities_with_roles[0].active">
                            <v-icon color="primary" small class="mr-2">mdi-check-decagram-outline</v-icon>
                            Tak
                        </template>
                        <template v-else>
                            <v-icon color="secondary" small class="mr-2">mdi-alert-decagram-outline</v-icon>
                            Nie
                        </template>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-menu offset-y class="component-background">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <v-icon>mdi-dots-vertical</v-icon>
                                </v-btn>
                            </template>
                            <v-list dense color="component-background" class="cursor-pointer">
                                <template  v-if="!item.universities_with_roles[0].verified">
                                    <v-list-item>
                                        <v-list-item-title @click="openVerifyWorkerDialog(item)">
                                            Zweryfikuj
                                        </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-title @click="openVerifyWorkerDialog(item)">
                                            Odrzuć
                                        </v-list-item-title>
                                    </v-list-item>
                                </template>

                                <template v-else>
                                    <v-list-item>
                                        <v-list-item-title @click="$router.push({name: 'user', params: {id: item.id}})">
                                            Wyświetl profil
                                        </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-title @click="openChangeRoleDialog(item)">
                                            Zmień role
                                        </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-title
                                            v-if="!item.universities_with_roles[0].active"
                                            @click="$router.push({name: 'user', params: {id: item.id}})"
                                        >
                                            Aktywuj
                                        </v-list-item-title>
                                        <v-list-item-title
                                            v-else
                                            @click="$router.push({name: 'user', params: {id: item.id}})"
                                        >
                                            Dezaktywuj
                                        </v-list-item-title>
                                    </v-list-item>
                                </template>
                            </v-list>
                        </v-menu>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import SelectRolesDialog from "../../Roles/SelectRolesDialog";
import CustomConfirmDialog from "../../_General/CustomConfirmDialog";

export default {
    name: "TheUniversityWorkersList",
    components: {CustomConfirmDialog, SelectRolesDialog, CustomCardTitle, CustomCard},

    props: ['search'],

    data() {
        return {
            selectedItem: null,
            selectedWorkerRolesIds: '',
            show: true,
            headers: [
                {text: 'Imię i nazwisko', value: 'full_name'},
                {text: 'Role', value: 'rolesChips'},
                {text: 'Zweryfikowany', value: 'verified', sortable: false, align: 'center'},
                {text: 'Aktywny', value: 'active', sortable: false, align: 'center'},
                {text: 'Akcje', value: 'actions', sortable: false, align: 'center'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            workers: 'university/workers',
            workersLoading: 'university/workersLoading',
            dialogs: 'helpers/dialogs',
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchWorkers: 'university/fetchWorkers',
            toggleDialog: 'helpers/toggleDialog',
            changeUniversityWorkerRoles: 'university/changeUniversityWorkerRoles',
            verifyUniversityWorker: 'university/verifyUniversityWorker'
        }),

        openChangeRoleDialog(item) {
            this.selectedItem = item;
            this.selectedWorkerRolesIds = item.universities_with_roles[0].roles.map((role) => {
                return role.id;
            });
            this.toggleDialog({key: 'DIALOG_FIELD_SELECT_ROLES', val: true});
        },

        openVerifyWorkerDialog(item) {
            this.selectedItem = item;
            this.toggleDialog({key: 'DIALOG_FIELD_VERIFY_UNIVERSITY_WORKER', val: true});
        },

        changeRoles(rolesIds) {
            this.changeUniversityWorkerRoles({
                slug: this.$route.params.slug,
                userId: this.selectedItem.id,
                userUniversityId: this.selectedItem.universities_with_roles[0].id,
                rolesIds: rolesIds
            }).then((response) => {
                this.setSnackbar({message: 'Role zostały zmienione!', color: 'success'});
                this.toggleDialog({key: 'DIALOG_FIELD_SELECT_ROLES', val: false});
                this.fetchWorkers(this.$route.params.slug);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się zmienić ról!', color: 'error'});
                this.toggleDialog({key: 'DIALOG_FIELD_SELECT_ROLES', val: false});
            });
        },

        verifyWorker() {
            this.verifyUniversityWorker({
                slug: this.$route.params.slug,
                userId: this.selectedItem.id,
                userUniversityId: this.selectedItem.universities_with_roles[0].id
            }).then((response) => {
                this.setSnackbar({message: 'Pracownik został zweryfikowany!', color: 'success'});
                this.toggleDialog({key: 'DIALOG_FIELD_VERIFY_UNIVERSITY_WORKER', val: false});
                this.fetchWorkers(this.$route.params.slug);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się zweryfikować pracownika!', color: 'error'});
                this.toggleDialog({key: 'DIALOG_FIELD_VERIFY_UNIVERSITY_WORKER', val: false});
            });
        }
    },

    created() {
        this.fetchWorkers(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
