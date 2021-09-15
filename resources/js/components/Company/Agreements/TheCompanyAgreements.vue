<template>
    <v-container fluid class="pa-0">
        <accept-agreement-dialog :slug="selectedAgreement.slug"></accept-agreement-dialog>
        <reject-agreement-dialog :slug="selectedAgreement.slug"></reject-agreement-dialog>

        <page-title>
            <template v-slot:default>Umowy</template>
            <template v-slot:subheader>Lista umów przypisanych do {{
                    !companyLoading ? company.name : 'tej firmy'
                }}
            </template>
        </page-title>

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
                        <template v-slot:default>Lista umów</template>
                    </custom-card-title>
                    <v-data-table
                        :items="companyAgreements"
                        :loading="companyAgreementsLoading"
                        :headers="headers"
                        class="table-cursor component-background"
                        :search="search"
                    >
                        <template v-slot:item.status.display_name="{ item }">
                            <v-chip small outlined :color="item.status.hex_color">
                                {{ item.status.display_name }}
                            </v-chip>
                        </template>
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
                                    <v-list-item :to="{name: 'agreement', params: {slug: item.slug}}">
                                        <v-list-item-title>
                                            Wyświetl umowę
                                        </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item
                                        v-if="item.offer"
                                        :to="{name: 'offer', params: {slug: item.offer.slug}}"
                                    >
                                        <v-list-item-title class="cursor-pointer">
                                            Wyświetl ofertę
                                        </v-list-item-title>
                                    </v-list-item>
                                    <v-divider
                                        v-if="item.status.group === 'new'"
                                        v-has-company-role="['company_owner']"
                                    ></v-divider>
                                    <v-list-item
                                        @click="accept(item)"
                                        v-if="item.status.group === 'new'"
                                        v-has-company-role="['company_owner','company_manager']"
                                    >
                                        <v-list-item-title class="cursor-pointer">Akceptuj</v-list-item-title>
                                    </v-list-item>
                                    <v-list-item
                                        @click="reject(item)"
                                        v-if="item.status.group === 'new'"
                                        v-has-company-role="['company_owner','company_manager']"
                                    >
                                        <v-list-item-title class="cursor-pointer">Odrzuć</v-list-item-title>
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
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import AcceptAgreementDialog from "../../Agreements/AcceptAgreementDialog";
import RejectAgreementDialog from "../../Agreements/RejectAgreementDialog";
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheCompanyAgreements",
    components: {CustomCardTitle, CustomCard, PageTitle, RejectAgreementDialog, AcceptAgreementDialog, ExpandCard},

    data() {
        return {
            search: null,
            selectedAgreement: {
                slug: null,
            },
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Miejsca', value: 'places_number'},
                {text: 'Od', value: 'date_from'},
                {text: 'Do', value: 'date_to'},
                {text: 'Status', value: 'status.display_name'},
                {text: 'Akcje', value: 'actions'},
            ],
        }
    },

    methods: {
        ...mapActions({
            fetchCompanyAgreements: 'company/fetchCompanyAgreements',
            toggleAcceptAgreementDialog: 'helpers/toggleAcceptAgreementDialog',
            toggleRejectAgreementDialog: 'helpers/toggleRejectAgreementDialog',
            setBreadcrumbs: 'helpers/setBreadcrumbs',
        }),

        formatDate(date) {
            if (date) {
                return moment(date).format('DD.MM.YYYY');
            }

            return '---';
        },

        accept(item) {
            this.selectedAgreement.slug = item.slug;
            this.toggleAcceptAgreementDialog(true);
        },

        reject(item) {
            this.selectedAgreement.slug = item.slug;
            this.toggleRejectAgreementDialog(true);
        }
    },

    computed: {
        ...mapGetters({
            company: 'company/company',
            companyLoading: 'company/companyLoading',
            companyAgreements: 'company/companyAgreements',
            companyAgreementsLoading: 'company/companyAgreementsLoading',
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {
                text: this.company.name ?? 'Firma',
                to: {name: 'company', params: {slug: this.$route.params.slug}},
                exact: true
            },
            {text: 'Umowy', to: {name: 'company-agreements'}, exact: true},
        ])

        this.fetchCompanyAgreements(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>
.table-cursor tbody tr:hover {
    cursor: pointer;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
