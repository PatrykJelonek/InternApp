<template>
    <v-card elevation="0" color="card-background">
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Oferty</v-list-item-title>
                    <v-list-item-subtitle>Lista ofert dostępnych na twojej uczelni.</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn-toggle borderless dense>
                        <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    small
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="show = !show">
                                    <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                                </v-btn>
                            </template>
                            <span>{{ show ? 'Zwiń Listę' : 'Rozwiń Listę' }}</span>
                        </v-tooltip>
                    </v-btn-toggle>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-expand-transition>
            <v-row v-show="show" no-gutters>
                <v-col cols="12">
                    <v-data-table
                        :headers="headers"
                        :items="availableOffers"
                        :items-per-page="10"
                        :loading="availableOffersLoading"
                        class="elevation-1 card-background"
                        @click:row="openDialog"
                    >
                        <template v-slot:item.date_from="{ item }">
                            {{ formatDate(item.date_from) }}
                        </template>
                        <template v-slot:item.date_to="{ item }">
                            {{ formatDate(item.date_to) }}
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-btn icon x-small>
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-expand-transition>
        <v-dialog
            v-model="dialog"
            persistent
            max-width="800px"
        >
            <v-card v-if="selectedRow" color="card-background">
                <div v-if="!applyLoading">
                    <v-list color="card-background">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5 font-weight-medium">{{
                                        selectedRow.offer.name
                                    }}
                                </v-list-item-title>
                                <v-list-item-subtitle>{{ selectedRow.offer.company.name }}.</v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action>
                                <v-btn-toggle borderless dense>
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                small
                                                icon
                                                v-bind="attrs"
                                                v-on="on"
                                                @click="dialog = false"
                                            >
                                                <v-icon>mdi-close</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Zamknij</span>
                                    </v-tooltip>
                                </v-btn-toggle>
                            </v-list-item-action>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item class="mb-2" color="card-background">
                            <v-simple-table style="width: 100%;">
                                <template v-slot:default>
                                    <tbody style="border: none !important; " class="card-background">
                                    <tr>
                                        <td class="font-weight-bold" colspan="1">Nazwa:</td>
                                        <td colspan="3">{{ selectedRow.offer.name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold" colspan="1">Firma:</td>
                                        <td colspan="3">
                                            <router-link
                                                :to="{name: 'company', params: {slug: selectedRow.offer.company.slug}}">
                                                {{ selectedRow.offer.company.name }}
                                            </router-link>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold" colspan="1">Okres praktyki:</td>
                                        <td colspan="3">{{ formatDate(selectedRow.date_from) }} -
                                            {{ formatDate(selectedRow.date_to) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold" colspan="1">Adres:</td>
                                        <td colspan="3">
                                            {{
                                                selectedRow.offer.company.street + ' ' + selectedRow.offer.company.street_number + ', ' + selectedRow.offer.company.city.post_code + ' ' + selectedRow.offer.company.city.name
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold" colspan="1">Rozmowa rekrutacyjna:</td>
                                        <td colspan="1">{{ selectedRow.offer.interview ? 'Tak' : 'Nie' }}</td>
                                        <td class="font-weight-bold" colspan="1">Ilość miejsc:</td>
                                        <td colspan="1" class="text-left">{{ selectedRow.offer.places_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold" colspan="1">Opis:</td>
                                        <td colspan="3">
                                            {{ selectedRow.content }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold" colspan="1">Harmonogram:</td>
                                        <td colspan="3">
                                            {{ selectedRow.schedule }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-list-item>
                    </v-list>
                    <v-card-actions class="d-flex justify-end align-content-end" v-if="selectedRow.offer.places_number > 0">
                        <v-btn color="primary" outlined @click="apply">Aplikuj</v-btn>
                    </v-card-actions>
                </div>
                <div class="text-center" v-else>
                    <v-progress-circular
                        indeterminate
                        size="100"
                        width="8"
                        color="primary"
                        class="ma-10"
                    ></v-progress-circular>
                </div>
            </v-card>
        </v-dialog>
    </v-card>
</template>

<script>
import moment from 'moment';
import {mapActions, mapGetters} from "vuex";

export default {
    name: "StudentOffersList",

    data() {
        return {
            show: true,
            dialog: false,
            selectedRow: null,
            applyLoading: false,
            headers: [
                {text: 'Nazwa', value: 'offer.name'},
                {text: 'Od', value: 'date_from'},
                {text: 'Do', value: 'date_to'},
                {text: 'Kategoria', value: 'offer.category.name'},
                {text: 'Miasto', value: 'offer.company.city.name'},
                {text: 'Ilość Miejsc', value: 'offer.places_number'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            availableOffers: 'university/availableOffers',
            availableOffersLoading: 'university/availableOffersLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchAvailableOffers: 'university/fetchAvailableOffers',
            fetchUserUniversities: 'user/fetchUserUniversities',
            createInternship: 'internship/create',
            setSnackbar: 'snackbar/setSnackbar',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },

        openDialog(item) {
            this.selectedRow = item;
            this.dialog = true;
        },

        async apply() {
            this.applyLoading = true;
            await this.createInternship({
                offerId: this.selectedRow.offer.id,
                agreementId: this.selectedRow.id,
                companySupervisorId: this.selectedRow.offer.company_supervisor_id,
                universitySupervisorId: this.selectedRow.university_supervisor_id,
            }).then(() => {
                this.dialog = false;
                this.setSnackbar({message: 'Twoja aplikacja została wysłana!', color: 'success'});
                this.closeDialogInTime();
            }).catch((e) => {
                this.dialog = false;
                this.closeDialogInTime();
                this.setSnackbar({message: 'Coś poszło nie tak!', color: 'error'});

            });
        },

        closeDialogInTime() {
            setTimeout(() => {
                this.applyLoading = false;
            }, 1000);
        },
    },

    created() {
        this.fetchAvailableOffers().then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped lang="scss">
tr:hover {
    background: transparent !important;
}
</style>
