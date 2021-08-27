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
        >
            Czy chcesz usunąć tego pracownika z firmy?
        </custom-confirm-dialog>
        <custom-confirm-dialog
            :dialog-state="acceptCompanyWorkerDialog"
            :toggle-function="toggleAcceptCompanyWorkerDialog"
            :confirm-function="acceptWorker"
            :confirm-function-args="[selectedWorkerId]"
            title="Akceptuj pracownika"
        >
            Czy chcesz zaakceptować tego pracownika jako pracownika firmy?
        </custom-confirm-dialog>

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
                                            @click="toggleAcceptCompanyWorkerDialog(true)"
                                        >
                                            <v-list-item-content>
                                                <v-list-item-title>Akceptuj pracownika</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item
                                            class="cursor-pointer"
                                            @click="toggleDeleteCompanyWorkerDialog(true)"
                                        >
                                            <v-list-item-content>
                                                <v-list-item-title>Usuń pracownika</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </template>
                                    <template v-else>
                                        <v-list-item :to="{name: 'user', params: {id: item.id}}">
                                            <v-list-item-content>
                                                <v-list-item-title>Wyświetl profil</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item>
                                            <v-list-item-content>
                                                <v-list-item-title>Zmień rolę</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item v-if="!item.companies_with_roles[0].active">
                                            <v-list-item-content>
                                                <v-list-item-title>Aktywuj</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item v-else>
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

export default {
    name: "TheCompanyWorkers",
    components: {CustomCardTitle, CustomConfirmDialog, CustomCard, PageTitle},

    data() {
        return {
            search: null,
            selectedWorker: null,
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
