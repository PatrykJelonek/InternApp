<template>
    <v-container fluid class="pa-0">
        <accept-offer-dialog :name="selectedOffer.name" :slug="selectedOffer.slug"></accept-offer-dialog>
        <reject-offer-dialog :name="selectedOffer.name" :slug="selectedOffer.slug"></reject-offer-dialog>

        <page-title>
            <template v-slot:default>Oferty</template>
            <template v-slot:subheader>Lista ofert w serwisie</template>
        </page-title>

        <v-row no-gutters class="mb-10">
            <v-col cols="12">
                <custom-card>
                    <v-tabs>
                        <v-tab>Do weryfikacji</v-tab>
                    </v-tabs>
                </custom-card>
            </v-col>
        </v-row>

        <v-row no-gutters>
            <v-col cols="12">
                <custom-card>
                    <custom-card-title>
                        <template v-slot:default>Oferty</template>
                        <template v-slot:subheader>Lista ofert do akceptacji</template>
                        <template v-slot:actions>
                            <v-tooltip top>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        small
                                        icon
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="updateView">
                                        <v-icon>mdi-database-refresh-outline</v-icon>
                                    </v-btn>
                                </template>
                                <span>Pobierz kategorie</span>
                            </v-tooltip>
                        </template>
                    </custom-card-title>

                    <v-data-table
                        no-data-text="Nie ma jeszcze żadnych ofert do akceptacji"
                        :items="offers"
                        :loading="offersLoading"
                        :headers="headers"
                        class="component-background"
                    >
                        <template v-slot:item.supervisor="{ item }">
                            <router-link
                                class="primary--text"
                                link
                                small
                                :to="{name: 'user', params: {id: item.supervisor.id}}"
                            >
                                {{ item.supervisor.first_name + ' ' + item.supervisor.last_name }}
                            </router-link>
                        </template>
                        <template v-slot:item.status="{ item }">
                            <v-chip outlined small :color="item.status.hex_color">
                                {{ item.status.display_name }}
                            </v-chip>
                        </template>
                        <template v-slot:item.interview="{ item }">
                            <span :class="item.interview ? 'primary--text' : ''">{{ item.interview ? 'Tak' : 'Nie' }}</span>
                        </template>
                        <template v-slot:item.date_from="{ item }">
                            {{ formatDate(item.date_from) }}
                        </template>
                        <template v-slot:item.date_to="{ item }">
                            {{ formatDate(item.date_to) }}
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
                                <v-list dense>
                                    <v-list-item>
                                        <v-list-item-title
                                            @click.stop="openAcceptOfferDialog(item.name, item.slug)"
                                            class="link"
                                        >
                                            Akceptuj
                                        </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-title
                                            @click.stop="openRejectOfferDialog(item.name, item.slug)"
                                            class="link"
                                        >
                                            Odrzuć
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
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import AcceptOfferDialog from "./AcceptOfferDialog";
import RejectOfferDialog from "./RejectOfferDialog";
import ExpandCard from "../../_Helpers/ExpandCard";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import PageTitle from "../../_Helpers/PageTitle";

export default {
    name: "TheAdminOffers",
    components: {CustomCardTitle, CustomCard, ExpandCard, RejectOfferDialog, AcceptOfferDialog, PageTitle},
    data() {
        return {
            acceptOfferDialog: null,
            rejectOfferDialog: null,
            selectedOffer: {
                name: null,
                slug: null
            },
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Dostępne Miejsca', value: 'places_number'},
                {text: 'Kategoria', value: 'category.display_name'},
                {text: 'Opiekun', value: 'supervisor', sortable: false},
                {text: 'Od', value: 'date_from'},
                {text: 'Do', value: 'date_to'},
                {text: 'Interview', value: 'interview', sortable: false, align: 'center'},
                {text: 'Status', value: 'status', sortable: false},
                {text: 'Akcje', value: 'actions', sortable: false},
            ]
        }
    },

    computed: {
        ...mapGetters({
            offers: 'offer/offers',
            offersLoading: 'offer/offersLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchOffers: 'offer/fetchOffers',
            acceptOffer: 'offer/acceptOffer',
            rejectOffer: 'offer/rejectOffer',
            toggleAcceptOfferDialog: 'helpers/toggleAcceptOfferDialog',
            toggleRejectOfferDialog: 'helpers/toggleRejectOfferDialog',
            fetchNumberOfNewOffers: 'statistic/fetchNumberOfNewOffers',
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),

        formatDate(date) {
            if (date) {
                return moment(date).format('DD.MM.YYYY');
            }

            return '---';
        },

        openAcceptOfferDialog(name, slug) {
            this.selectedOffer.name = name;
            this.selectedOffer.slug = slug;
            this.toggleAcceptOfferDialog(true);
        },

        openRejectOfferDialog(name, slug) {
            this.selectedOffer.name = name;
            this.selectedOffer.slug = slug;
            this.toggleRejectOfferDialog(true);
        },

        updateView() {
            this.fetchNumberOfNewOffers().then(() => {
            }).catch((e) => {
            })
            this.fetchOffers({categories: null, statuses: ['new']}).then(() => {
            }).catch((e) => {
            });
        }
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Panel Administratora', to: {name: 'admin'}, exact: true},
            {text: 'Oferty Praktyk i Staży', disabled: true}
        ]);

        this.updateView();
    }
}
</script>

<style scoped>
.link {
    cursor: pointer;
}
</style>
