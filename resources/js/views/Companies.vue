<template>
    <v-container fluid class="pa-0">
        <custom-confirm-dialog
            :dialog-state="dialogs['DIALOG_FIELD_CONFIRM_JOINING_TO_COMPANY']"
            :toggle-function="toggleDialog"
            :dialog-key="'DIALOG_FIELD_CONFIRM_JOINING_TO_COMPANY'"
            :confirm-function="join"
            title="Dołącz do firmy"
            :subheader="`Czy na pewno chcesz dołączyć do tej firmy?`"
            confirm-btn-text="Dołącz"
        >
            <validation-observer ref="observer" v-slot="{ validate }">
                <v-form>
                    <v-row>
                        <v-col cols="12">
                            <validation-provider
                                :vid="accessCode"
                                rules="required|max:8"
                                v-slot="{ errors }"
                            >
                                <v-text-field
                                    dense
                                    v-model="accessCode"
                                    outlined
                                    label="Kod dostępu"
                                    hide-details="auto"
                                    max="8"
                                    :error-messages="errors"
                                ></v-text-field>
                            </validation-provider>
                        </v-col>
                    </v-row>
                </v-form>
            </validation-observer>
        </custom-confirm-dialog>
        <page-title>
            <template v-slot:default>Firmy</template>
            <template v-slot:subheader>Znajdź na liście swoją firmę i dołącz do niej.</template>
            <template v-slot:actions>
                <v-btn
                    outlined
                    color="primary"
                    @click="$router.push({name: 'create-company'})"
                >
                    Dodaj Firmę
                </v-btn>
            </template>
        </page-title>

        <v-row no-gutters>
            <v-col cols="12">
                <custom-card>
                    <v-text-field
                        hide-details
                        outlined
                        v-model="search"
                        prepend-inner-icon="mdi-magnify"
                        label="Szukaj"
                    ></v-text-field>
                </custom-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <custom-card>
                    <custom-card-title>
                        <template v-slot:default>Lista firm</template>
                        <template v-slot:subheader>Lista wszystkich firm dostępnych w serwisie.</template>
                    </custom-card-title>

                    <v-data-table
                        :headers="headers"
                        :items="companies"
                        :search="search"
                        class="component-background"
                        no-results-text="Ups... Nie udało się znaleźć szukanej firmy."
                        no-data-text="Ups... Wygląda, że nie mamy jeszcze żadnych firm w serwisie!"
                        loading-text="Pobieranie listy firm..."
                    >
                        <template v-slot:item.name="{item}">
                            <v-avatar :size="30" rounded class="mr-2">
                                <v-img lazy-src="" :src="item.logo_url ? '/'+item.logo_url : ''"
                                       :alt="'Logo uczelni ' + item.name">
                                    <template v-slot:placeholder>
                                        <v-row
                                            class="fill-height ma-0"
                                            align="center"
                                            justify="center"
                                        >
                                            <v-progress-circular
                                                indeterminate
                                                color="grey darken-5"
                                                width="1"
                                                size="20"
                                            ></v-progress-circular>
                                        </v-row>
                                    </template>
                                </v-img>
                            </v-avatar>
                            {{ item.name }}
                        </template>
                        <template v-slot:item.join="{item}">
                            <v-btn
                                small
                                outlined
                                color="primary"
                                :disabled="!canJoin(item.id)"
                                @click="openDialog(item.slug)"
                            >
                                Dołącz
                            </v-btn>
                        </template>
                    </v-data-table>
                </custom-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../components/_Helpers/PageTitle";
import PageLoader from "../components/_General/PageLoader";
import CustomCard from "../components/_General/CustomCard";
import CustomCardTitle from "../components/_General/CustomCardTitle";
import CustomConfirmDialog from "../components/_General/CustomConfirmDialog";
import {extend, ValidationObserver, ValidationProvider} from "vee-validate";

export default {
    name: "Companies",
    components: {
        CustomConfirmDialog,
        CustomCardTitle,
        CustomCard,
        PageLoader,
        PageTitle,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            accessCode: null,
            search: null,
            selectedCompanySlug: null,
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Adres', value: 'full_address'},
                {text: 'Kategoria', value: 'category.name'},
                {text: 'Dołącz', value: 'join'},
            ]
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            dialogs: 'helpers/dialogs',
            companies: 'company/companies',
            companiesLoading: 'company/companiesLoading',
            userCompanies: 'user/userCompanies',
            userCompaniesLoading: 'user/userCompaniesLoading',
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog',
            fetchUserCompanies: 'user/fetchUserCompanies',
            fetchCompanies: 'company/fetchCompanies',
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            addWorkerToCompany: 'company/addWorkerToCompany',
            setSnackbar: 'snackbar/setSnackbar'
        }),

        canJoin(id) {
            let userCanJoin = true;

            this.userCompanies.forEach((userCompany) => {
                if (userCompany.id === id) {
                    userCanJoin = false;
                }
            });

            return userCanJoin;
        },

        openDialog(slug) {
            if (slug) {
                this.selectedCompanySlug = slug;
                this.toggleDialog({key: 'DIALOG_FIELD_CONFIRM_JOINING_TO_COMPANY', val: true});
            }
        },

        async join() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {
                    this.addWorkerToCompany({
                        slug: this.selectedCompanySlug,
                        userId: this.user.id,
                        accessCode: this.accessCode
                    }).then((response) => {
                        this.fetchUserCompanies();
                        this.toggleDialog({key: 'DIALOG_FIELD_CONFIRM_JOINING_TO_COMPANY', val: false});
                        this.setSnackbar({
                            message: 'Zostałeś dodany do firmy!',
                            color: 'success'
                        });
                    }).catch((e) => {
                        if (e.response.status === 422) {
                            this.$refs.observer.setErrors(e.response.data.errors);
                        } else {
                            this.toggleDialog({key: 'DIALOG_FIELD_CONFIRM_JOINING_TO_COMPANY', val: false});
                            this.setSnackbar({
                                message: 'Wystąpił problem, skontaktuj się administratorem!',
                                color: 'error'
                            });
                        }
                    });
                }
            });
        }
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Firmy', to: {name: 'companies'}, exact: true},
        ]);

        this.fetchCompanies().then(() => {
            this.fetchUserCompanies().then(() => {

            }).catch(() => {

            });
        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
