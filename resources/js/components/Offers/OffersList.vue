<template>
    <expand-card
        title="Dostępne Oferty"
        description="Lista dostępnych ofert w systemie."
    >
        <v-data-table
            no-data-text="Nie ma jeszcze żadnych ofert do akceptacji"
            :items="offers"
            :loading="offersLoading"
            :headers="headers"
            class="table-cursor"
            @click:row="(item) => {this.$router.push({name: 'offer', params: {slug: item.slug}})}"
        >
            <template v-slot:item.company="{ item }">
                <router-link
                    class="primary--text"
                    link
                    small
                    :to="{name: 'company', params: {slug: item.company.slug}}"
                >
                    {{ item.company.name }}
                </router-link>
            </template>
            <template v-slot:item.category="{ item }">
                {{ item.category.display_name }}
            </template>
            <template v-slot:item.date_from="{ item }">
                {{ formatDate(item.date_from) }}
            </template>
            <template v-slot:item.date_to="{ item }">
                {{ formatDate(item.date_to) }}
            </template>
            <template v-slot:item.interview="{ item }">
                <v-chip
                    small
                    :color="item.interview ? 'primary' : 'grey lighten-3'"
                >
                    {{ item.interview ? 'Tak' : 'Nie' }}
                </v-chip>
            </template>
            <template v-slot:item.created_at="{ item }">
                {{ formatDate(item.created_at) }}
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
                                class="link"
                            >
                                Akceptuj
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title
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
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import ExpandCard from "../_Helpers/ExpandCard";

export default {
    name: "OffersList",
    components: {ExpandCard},
    data() {
        return {
            show: true,
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
            offers: 'offer/offers',
            offersLoading: 'offer/offersLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchOffers: 'offer/fetchOffers',
        }),

        formatDate(date) {
            if (date) {
                return moment(date).format('DD.MM.YYYY');
            }

            return '---';
        },
    },

    created() {
        this.fetchOffers({categories: null, statuses: ['accepted']}).then(() => {
            this.isLoading = false;
        });
    }
}
</script>

<style lang="scss">
.table-cursor tbody tr:hover {
    cursor: pointer;
}
</style>
