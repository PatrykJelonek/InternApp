<template>
    <v-row>
        <v-col cols="12">
            <expand-card title="Lista Ofert" :description="`Lista ofert przypisanych do ${company.name}`" class="mt-10">
                <v-row no-gutters class="px-5 pt-5 pb-2">
                    <v-col cols="2" class="mr-5">
                        <v-text-field
                            v-model="search.name"
                            label="Nazwa"
                            outlined
                            dense
                            hide-details
                            @change="searchByName"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="2" class="mr-5">
                        <v-combobox
                            v-model="search.categories"
                            label="Kategorie"
                            :items="categories"
                            :item-value="(category) => category.name"
                            :item-text="(category) => category.display_name"
                            outlined
                            dense
                            hide-details
                            small-chips
                            multiple
                            @input="searchByCategories"
                        ></v-combobox>
                    </v-col>
                    <v-col cols="2" class="mr-5">
                        <v-combobox
                            v-model="search.statuses"
                            label="Statusy"
                            outlined
                            dense
                            hide-details
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
import {mapActions, mapGetters} from "vuex";
import moment from "moment";

export default {
    name: "TheCompanyOffers",
    components: {ExpandCard},

    data() {
        return {
            searchedItems: [],
            search: {
                name: null,
                categories: null,
                statuses: null,
            },
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Dostępne Miejsca', value: 'places_number'},
                {text: 'Kategoria', value: 'category.display_name'},
                {text: 'Opiekun', value: 'supervisor'},
                {text: 'Od', value: 'date_from'},
                {text: 'Do', value: 'date_to'},
                {text: 'Interview', value: 'interview'},
                {text: 'Status', value: 'status'},
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
        }),

        formatDate(date) {
            if (date) {
                return this.moment(date).format('DD.MM.YYYY');
            }

            return '---';
        },

        searchByName() {

        },
    },

    computed: {
        ...mapGetters({
            company: 'company/company',
            companyLoading: 'company/companyLoading',
            companyOffers: 'company/companyOffers',
            companyOffersLoading: 'company/companyOffersLoading',
        }),

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
                this.searchedItems = this.companyOffers.filter((offer) => {
                    return this.search.statuses.includes(offer.status.name);
                });
            } else {
                this.searchedItems = this.companyOffers;
            }
        }
    },

    created() {
        this.fetchCompanyOffers(this.company.slug).then(() => {
            this.searchedItems = this.companyOffers;
        }).catch((e) => {

        });
    }

}
</script>

<style scoped>

</style>
