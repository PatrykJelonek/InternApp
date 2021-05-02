<template>
    <expand-card
        title="Oferty"
        description="Lista ofert dostępnych na twojej uczelni."
    >
        <v-data-table
            :headers="headers"
            :items="availableOffers"
            :items-per-page="10"
            :loading="availableOffersLoading"
            class="elevation-1 card-background"
            @click:row="(item) => {this.$router.push({name: 'agreement', params: {slug: item.slug}})}"
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
    </expand-card>
</template>

<script>
import moment from 'moment';
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";

export default {
    name: "StudentOffersList",
    components: {ExpandCard},
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
                {text: 'Kategoria', value: 'offer.category.display_name'},
                {text: 'Miasto', value: 'offer.company.city.name'},
                {text: 'Ilość Miejsc', value: 'places_number'},
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
