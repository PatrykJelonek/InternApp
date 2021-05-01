<template>
    <v-row>
        <accept-offer-dialog :name="selectedOffer.name" :slug="selectedOffer.slug"></accept-offer-dialog>
        <reject-offer-dialog :name="selectedOffer.name" :slug="selectedOffer.slug"></reject-offer-dialog>
        <v-col cols="12">
            <expand-card
                title="Nowe Oferty"
                description="Lista ofert do akceptacji"
            >
                <template v-slot:buttons>
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
                <v-data-table
                    no-data-text="Nie ma jeszcze żadnych ofert do akceptacji"
                    :items="offers"
                    :loading="offersLoading"
                    :headers="headers"
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
            </expand-card>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import AcceptOfferDialog from "./AcceptOfferDialog";
import RejectOfferDialog from "./RejectOfferDialog";
import ExpandCard from "../../_Helpers/ExpandCard";

export default {
    name: "TheAdminOffers",
    components: {ExpandCard, RejectOfferDialog, AcceptOfferDialog},
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
                {text: 'Interview', value: 'interview'},
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
            fetchNumberOfNewOffers: 'statistic/fetchNumberOfNewOffers'
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
        this.updateView();
    }
}
</script>

<style scoped>
.link {
    cursor: pointer;
}
</style>
