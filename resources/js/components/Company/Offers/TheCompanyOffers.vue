<template>
    <v-container fluid class="pa-0">
        <create-offer-dialog></create-offer-dialog>

        <page-title>
            <template v-slot:default>Oferty praktyk i staży</template>
            <template v-slot:subheader>Lista ofert przypisanych do {{ company.name }}</template>
            <template v-slot:actions>
                <v-btn
                    outlined
                    color="primary"
                    @click="toggleCreateOfferDialog(true)"
                >
                    Dodaj ofertę
                </v-btn>
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
                        <template v-slot:default>Lista ofert</template>
                    </custom-card-title>
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-data-table
                                :no-data-text="`Niestety, ale ${company.name} nie posiada jeszcze ofert w systemie`"
                                :headers="headers"
                                :items="companyOffers"
                                :loading="companyOffersLoading"
                                :search="search"
                                class="component-background"
                            >
                                <template v-slot:item.supervisor.full_name="{ item }">
                                    <router-link class="primary--text" link small
                                                 :to="{name: 'user', params: {id: item.supervisor.id}}">
                                        {{ item.supervisor.full_name}}
                                    </router-link>
                                </template>
                                <template v-slot:item.status.display_name="{ item }">
                                    <v-chip small :color="item.status.hex_color" outlined>
                                        {{ item.status.display_name }}
                                    </v-chip>
                                </template>
                                <template v-slot:item.interview="{ item }">
                                    <v-icon :color="item.interview ? 'primary' : 'error'">
                                        {{ item.interview ? 'mdi-check' : 'mdi-close' }}
                                    </v-icon>
                                </template>
                                <template v-slot:item.date_from="{ item }">
                                    {{ formatDate(item.date_from) }}
                                </template>
                                <template v-slot:item.date_to="{ item }">
                                    {{ formatDate(item.date_to) }}
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
                                            <v-list-item>
                                                <v-list-item-title @click="$router.push({name: 'offer', params: {slug: item.slug}})">
                                                    Zobacz ofertę
                                                </v-list-item-title>
                                            </v-list-item>
                                            <v-list-item>
                                                <v-list-item-title @click="$router.push({name: 'offer', params: {slug: item.slug}})">
                                                    Usuń ofertę
                                                </v-list-item-title>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>
                                </template>
                            </v-data-table>
                        </v-col>
                    </v-row>
                </custom-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters, mapState} from "vuex";
import moment from "moment";
import FormDialog from "../../_General/FormDialog";
import CreateOfferDialog from "./CreateOfferDialog";
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheCompanyOffers",
    components: {CustomCardTitle, CustomCard, PageTitle, CreateOfferDialog, FormDialog, ExpandCard},

    data() {
        return {
            search: null,
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Miejsca', value: 'places_number'},
                {text: 'Opiekun', value: 'supervisor.full_name'},
                {text: 'Od', value: 'date_from'},
                {text: 'Do', value: 'date_to'},
                {text: 'Interview', value: 'interview', align: 'center', sortable: false},
                {text: 'Status', value: 'status.display_name'},
                {text: 'Akcje', value: 'actions', sortable: false},
            ],
        }
    },

    methods: {
        ...mapActions({
            fetchCompanyOffers: 'company/fetchCompanyOffers',
            toggleCreateOfferDialog: 'helpers/toggleCreateOfferDialog',
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),

        formatDate(date) {
            if (date) {
                return moment(date).format('DD.MM.YYYY');
            }

            return '---';
        },
    },

    computed: {
        ...mapGetters({
            company: 'company/company',
            companyLoading: 'company/companyLoading',
            companyOffers: 'company/companyOffers',
            companyOffersLoading: 'company/companyOffersLoading',
            createOfferDialog: 'helpers/createOfferDialog',
        }),

        searchByName() {
            if (this.search.name !== null && this.search.name.length > 0) {
                this.searchedItems = this.companyOffers.filter((offer) => {
                    return offer.name.toUpperCase().trim().indexOf(this.search.name.toUpperCase().trim()) > -1;
                });
            } else {
                this.searchedItems = this.companyOffers;
            }
        },

        searchByCategories() {
            if (this.search.categories !== null && this.search.categories.length > 0) {
                let categories = this.search.categories.map(x => x['name']);

                this.searchedItems = this.companyOffers.filter((offer) => {
                    return categories.includes(offer.category.name);
                });
            } else {
                this.searchedItems = this.companyOffers;
            }
        },

        searchByStatuses() {
            if (this.search.statuses !== null && this.search.statuses.length > 0) {
                let statuses = this.search.statuses.map(x => x['name']);

                this.searchedItems = this.companyOffers.filter((offer) => {
                    return statuses.includes(offer.status.name);
                });
            } else {
                this.searchedItems = this.companyOffers;
            }
        },

        updateSearchedItems() {
            this.companyOffers.forEach((offer) => {
                this.searchedItems = this.companyOffers;
                this.comboboxElements.categories.push(offer.category);
                this.comboboxElements.statuses.push(offer.status);
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
            {text: 'Umowy', to: {name: 'company-offers'}, exact: true},
        ]);

        this.$store.subscribe(mutation => {
            if (mutation.type === 'company/UNSHIFT_COMPANY_OFFER') {
                this.updateSearchedItems();
            }
        });

        this.fetchCompanyOffers(this.company.slug).then(() => {

        }).catch((e) => {

        });
    },
}
</script>

<style scoped>

</style>
