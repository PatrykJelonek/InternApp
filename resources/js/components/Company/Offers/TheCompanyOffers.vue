<template>
    <v-row no-gutters>
        <create-offer-dialog></create-offer-dialog>
        <v-col cols="12">
            <expand-card title="Lista Ofert" :description="`Lista ofert przypisanych do ${company.name}`" class="mt-10">
                <template slot="buttons">
                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                small
                                icon
                                v-bind="attrs"
                                v-on="on"
                                @click="toggleCreateOfferDialog(true)"
                            >
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                        </template>
                        <span>Dodaj Ofertę</span>
                    </v-tooltip>
                </template>
                <v-row no-gutters class="px-5 pt-5 pb-2">
                    <v-col
                        cols="12"
                        md="12"
                        lg="5"
                        xl="3"
                        class="mr-5"
                        v-bind:class="$vuetify.breakpoint.mdAndDown ? 'mb-5' : ''"
                    >
                        <v-text-field
                            v-model="search.name"
                            label="Nazwa"
                            outlined
                            dense
                            hide-details
                            clearable
                            @input="searchByName"
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        md="12"
                        lg="3"
                        xl="3"
                        class="mr-5"
                        v-bind:class="$vuetify.breakpoint.mdAndDown ? 'mb-5' : ''"
                    >
                        <v-combobox
                            v-if="comboboxElements.categories.length > 1"
                            v-model="search.categories"
                            label="Kategorie"
                            :items="comboboxElements.categories"
                            :item-value="(category) => category.name"
                            :item-text="(category) => category.display_name"
                            outlined
                            dense
                            hide-details
                            small-chips
                            clearable
                            multiple
                            @input="searchByCategories"
                        ></v-combobox>
                    </v-col>
                    <v-col cols="12" md="12" lg="3" xl="3">
                        <v-combobox
                            v-if="comboboxElements.statuses.length > 1"
                            v-model="search.statuses"
                            label="Statusy"
                            :items="comboboxElements.statuses"
                            :item-value="(status) => status.name"
                            :item-text="(status) => status.display_name"
                            outlined
                            clearable
                            dense
                            hide-details
                            small-chips
                            multiple
                            @input="searchByStatuses"
                        ></v-combobox>
                    </v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col cols="12">
                        <v-data-table
                            :no-data-text="`Niestety, ale ${company.name} nie posiada jeszcze ofert w systemie`"
                            :headers="headers"
                            :items="searchedItems"
                            :loading="companyOffersLoading"
                            class="component-background"
                        >
                            <template v-slot:item.supervisor="{ item }">
                                <router-link class="primary--text" link small
                                             :to="{name: 'user', params: {id: item.supervisor.id}}">
                                    {{ item.supervisor.first_name + ' ' + item.supervisor.last_name }}
                                </router-link>
                            </template>
                            <template v-slot:item.status="{ item }">
                                <v-chip small :color="item.status.hex_color">
                                    {{ item.status.display_name }}
                                </v-chip>
                            </template>
                            <template v-slot:item.interview="{ item }">
                                <v-chip small :color="item.interview ? '#00E676' : ''">
                                    {{ item.interview ? 'Tak' : 'Nie' }}
                                </v-chip>
                            </template>
                            <template v-slot:item.date_from="{ item }">
                                {{ formatDate(item.date_from) }}
                            </template>
                            <template v-slot:item.date_to="{ item }">
                                {{ formatDate(item.date_to) }}
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </expand-card>
        </v-col>
    </v-row>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters, mapState} from "vuex";
import moment from "moment";
import FormDialog from "../../_General/FormDialog";
import CreateOfferDialog from "./CreateOfferDialog";

export default {
    name: "TheCompanyOffers",
    components: {CreateOfferDialog, FormDialog, ExpandCard},

    data() {
        return {
            searchedItems: [],
            search: {
                name: null,
                categories: null,
                statuses: null,
            },
            comboboxElements: {
                categories: [],
                statuses: [],
            },
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Dostępne Miejsca', value: 'places_number'},
                {text: 'Kategoria', value: 'category.display_name'},
                {text: 'Opiekun', value: 'supervisor', sortable: false},
                {text: 'Od', value: 'date_from'},
                {text: 'Do', value: 'date_to'},
                {text: 'Interview', value: 'interview'},
                {text: 'Status', value: 'status', sortable: false},
            ],
            categories: [
                {id: 1, name: 'programing', display_name: 'Programowanie'},
                {id: 2, name: 'computer_graphic', display_name: 'Grafika Komputerowa'},
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
            {text: 'Firma', to: {name: 'company', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Umowy', to: {name: 'company-offers'}, exact: true},
        ]);

        this.$store.subscribe(mutation => {
            if (mutation.type === 'company/UNSHIFT_COMPANY_OFFER') {
                this.updateSearchedItems();
            }
        });

        this.fetchCompanyOffers(this.company.slug).then(() => {
            this.updateSearchedItems();
        }).catch((e) => {

        });
    },
}
</script>

<style scoped>

</style>
