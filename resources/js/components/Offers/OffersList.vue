<template>
    <v-container fluid class="pa-0">
        <create-agreement-dialog></create-agreement-dialog>
        <custom-confirm-dialog
            title="Aplikacja na praktykę"
            :dialog-state="dialogs['DIALOG_FIELD_CONFIRM_INTERNSHIP_APPLICATION']"
            :toggle-function="toggleCustomDialog"
            :confirm-function="apply"
            dialog-key="DIALOG_FIELD_CONFIRM_INTERNSHIP_APPLICATION"
        >
            Czy na pewno chcesz aplikować na tą praktykę?
        </custom-confirm-dialog>

        <custom-card class="mb-5">
            <v-row no-gutters>
                <v-col cols="12">
                    <v-text-field
                        outlined
                        prepend-inner-icon="mdi-magnify"
                        hide-details
                        v-model="search"
                        label="Szukaj"
                    ></v-text-field>
                </v-col>
            </v-row>
        </custom-card>

        <v-data-iterator
            :items="availableStudentOffers"
            item-key="id"
            :items-per-page="10"
            :loading="offersLoading"
            locale="pl-PL"
            :search="search"
        >
            <template v-slot:default="{ items, isExpanded, expand }">
                <v-row>
                    <v-col
                        cols="12"
                        v-for="offer in items"
                        :key="offer.id"
                    >
                        <offers-list-row
                            :name="offer.name"
                            :address="offer.company.full_address"
                            :category="offer.category ? offer.category.display_name : null"
                            :interview="offer.interview"
                            :company-name="offer.company.name"
                            :date-range="formatDate(offer.date_from) + ' - ' + formatDate(offer.date_to)"
                            :logo-url="offer.company.logo_url"
                            :slug="offer.slug"
                            :offer="offer"
                            :for-student="isStudent"
                            :can-apply="!userInternshipsLoading && userInternships.length < 1"
                        ></offers-list-row>
                    </v-col>
                </v-row>
            </template>

            <template v-slot:no-data>
                <v-row>
                    <v-col cols="12" class="d-flex justify-center align-center">
                        Niestety, ale Twoja uczelnia nie dodała jeszcze żadnych ofert praktyk!
                    </v-col>
                </v-row>
            </template>

            <template v-slot:no-results>
                <v-row>
                    <v-col cols="12" class="d-flex justify-center align-center pa-5">
                        Niestety, ale Twoja uczelnia nie dodała jeszcze żadnych ofert praktyk!
                    </v-col>
                </v-row>
            </template>

            <template v-slot:loading>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <v-progress-circular color="primary" size="80" indeterminate></v-progress-circular>
                    </v-col>
                </v-row>
            </template>
        </v-data-iterator>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import ExpandCard from "../_Helpers/ExpandCard";
import CreateAgreementDialog from "../Agreements/CreateAgreementDialog";
import CustomCard from "../_General/CustomCard";
import OfferCard from "./OfferCard";
import OffersListRow from "./OffersListRow";
import CreateInternshipDialog from "./Student/CreateInternshipDialog";
import CustomConfirmDialog from "../_General/CustomConfirmDialog";

export default {
    name: "OffersList",
    components: {
        CustomConfirmDialog,
        CreateInternshipDialog, OffersListRow, OfferCard, CustomCard, CreateAgreementDialog, ExpandCard},
    data() {
        return {
            isStudent: true,
            search: null,
            show: true,
            selectedOffer: null,
            allOffers: [],
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Kategoria', value: 'category'},
                {text: 'Firma', value: 'company'},
                {text: 'Miejsca', value: 'places_number'},
                {text: 'Od', value: 'date_from'},
                {text: 'Do', value: 'date_to'},
                {text: 'Interview', value: 'interview'},
                {text: 'Dodano', value: 'created_at'},
                {text: 'Akcje', value: 'actions'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            dialogs: 'helpers/dialogs',
            dialogArgs: 'helpers/dialogsArgs',
            userInternships: 'user/internships',
            userInternshipsLoading: 'user/internshipsLoading',
            offers: 'offer/offers',
            offersLoading: 'offer/offersLoading',
            availableStudentOffers: 'university/availableOffers',
            availableStudentOffersLoading: 'university/availableOffersLoading'
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchOffers: 'offer/fetchOffers',
            toggleCreateAgreementDialog: 'helpers/toggleCreateAgreementDialog',
            toggleDialog: 'helpers/toggleCreateInternshipDialog',
            toggleCustomDialog: 'helpers/toggleDialog',
            fetchAvailableOffers: 'university/fetchAvailableOffers',
            fetchUserInternships: 'user/fetchInternships',
            applyToInternship: 'agreement/applyToInternship',
        }),

        setSelectedOffer(offer) {
            this.selectedOffer = offer;
        },

        formatDate(date) {
            if (date) {
                return moment(date).format('DD.MM.YYYY');
            }

            return '---';
        },

        async apply(slug) {
            await this.applyToInternship({slug: this.dialogArgs['DIALOG_FIELD_CONFIRM_INTERNSHIP_APPLICATION'][0]}).then(() => {
                this.setSnackbar({message: 'Aplikacja na praktykę została wysłana!', color: 'success'});
            }).catch((e) => {
                this.setSnackbar({message: 'Coś poszło nie tak! Skontaktuj się administratorem serwisu!', color: 'error'});
            }).finally(() => {
                this.toggleCustomDialog({key: 'DIALOG_FIELD_CONFIRM_INTERNSHIP_APPLICATION', val: false});
                this.setDialogArgs({key: 'DIALOG_FIELD_CONFIRM_INTERNSHIP_APPLICATION', val: null});
            });
        }
    },

    created() {
        this.fetchOffers({categories: null, statuses: ['accepted'], onlyWithPlaces: true}).then(() => {
            this.isLoading = false;
        });

        this.fetchAvailableOffers().then(() => {

        }).catch((e) => {

        });

        this.fetchUserInternships().then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style lang="scss">
.table-cursor tbody tr:hover {
    cursor: pointer;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
