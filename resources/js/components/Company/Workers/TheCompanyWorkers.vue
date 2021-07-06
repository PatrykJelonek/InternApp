<template>
    <v-container fluid class="pa-0">
        <page-title>
            Pracownicy
            <template v-slot:subheader>Lista pracowników {{ company.name }}</template>
        </page-title>
        <custom-confirm-dialog
            :dialog-state="deleteCompanyWorkerDialog"
            :toggle-function="toggleDeleteCompanyWorkerDialog"
            :confirm-function="deleteWorker"
            :confirm-function-args="[selectedWorkerId]"
            title="Usuń pracownika"
            :description="selectedWorkerFullName ? 'Czy na pewno chcesz usunąć ' + selectedWorkerFullName + ' z firmy?' : 'Czy chcesz usunąć tego pracownika z firmy'"
        ></custom-confirm-dialog>
        <custom-confirm-dialog
            :dialog-state="acceptCompanyWorkerDialog"
            :toggle-function="toggleAcceptCompanyWorkerDialog"
            :confirm-function="acceptWorker"
            :confirm-function-args="[selectedWorkerId]"
            title="Akceptuj pracownika"
            :description="selectedWorkerFullName ? 'Czy na pewno chcesz zaakceptować ' + selectedWorkerFullName + ' jako pracownika firmy?' : 'Czy chcesz zaakceptować tego pracownika jako pracownika firmy?'"
        ></custom-confirm-dialog>
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
                        <template v-slot:item.status_company="{item}">
                            <v-chip outlined small :color="item.pivot.active ? 'primary' : ''">
                                {{ item.pivot.active ? 'Aktywne' : 'Nieaktywne' }}
                            </v-chip>
                        </template>
                        <template v-slot:item.roles="{item}">
                            <v-chip-group v-if="item.roles">
                                <v-chip outlined small v-for="role in item.company_roles">{{
                                        role.display_name
                                    }}
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
                                        dark
                                        v-bind="attrs"
                                        v-on="on"
                                        icon
                                    >
                                        <v-icon>mdi-dots-vertical</v-icon>
                                    </v-btn>
                                </template>
                                <v-list dense class="component-background lighten-1">
                                    <v-list-item class="cursor-pointer"
                                                 @mouseup="selectedWorkerFullName = item.full_name; selectedWorkerId = item.id"
                                                 v-if="!item.pivot.active"
                                                 @click="toggleAcceptCompanyWorkerDialog(true)">
                                        <v-list-item-icon>
                                            <v-icon>mdi-account-check-outline</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-content>
                                            <v-list-item-title>Akceptuj pracownika</v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item class="cursor-pointer"
                                                 @mouseup="selectedWorkerFullName = item.full_name; selectedWorkerId = item.id"
                                                 @click="toggleDeleteCompanyWorkerDialog(true)">
                                        <v-list-item-icon>
                                            <v-icon>mdi-delete-outline</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-content>
                                            <v-list-item-title>Usuń pracownika</v-list-item-title>
                                        </v-list-item-content>
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
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";
import CustomConfirmDialog from "../../_General/CustomConfirmDialog";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheCompanyWorkers",
    components: {CustomCardTitle, CustomConfirmDialog, CustomCard, PageTitle},

    data() {
        return {
            selectedWorker: null,
            headers: [
                {text: "Imie i nazwisko", value: 'full_name', align: 'left'},
                {text: "Numer telefonu", value: 'phone', align: 'left'},
                {text: "Email", value: 'email', align: 'left'},
                {text: "Role", value: 'roles', align: 'left'},
                {text: "Status", value: 'status_company', align: 'center'},
                {text: "Akcje", value: 'actions', sortable: false}
            ],
        }
    },

    computed: {
        ...mapGetters({
            company: 'company/company',
            companyWorkers: 'company/companyWorkers',
            companyWorkersLoading: 'company/companyWorkersLoading',
            deleteCompanyWorkerDialog: 'helpers/deleteCompanyWorkerDialog',
            acceptCompanyWorkerDialog: 'helpers/acceptCompanyWorkerDialog',
        })
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            fetchCompanyWorkers: 'company/fetchCompanyWorkers',
            toggleDeleteCompanyWorkerDialog: 'helpers/toggleDeleteCompanyWorkerDialog',
            toggleAcceptCompanyWorkerDialog: 'helpers/toggleAcceptCompanyWorkerDialog',
            acceptCompanyWorker: 'company/acceptCompanyWorker',
            deleteCompanyWorker: 'company/deleteCompanyWorker',
            setSnackbar: 'snackbar/setSnackbar'
        }),

        deleteWorker(userId) {
            this.deleteCompanyWorker({slug: this.$route.params.slug, userId: userId}).then((response) => {
                this.toggleDeleteCompanyWorkerDialog(false);
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
            }).catch((e) => {
                this.setSnackbar({
                    message: 'Wystąpił problem podczas akceptacji użytkownika jako pracownika tej firmy',
                    color: 'error'
                });
                this.toggleAcceptCompanyWorkerDialog(false);
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
