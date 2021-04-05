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
                        :items="allOffers"
                        :items-per-page="5"
                        class="elevation-1"
                    >
                        <template v-slot:item.actions="{ item }">
                            <v-btn icon x-small>
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "StudentOffersList",

    data() {
        return {
            show: true,
            allOffers: [],
            headers: [
                {text: 'Nazwa', value: 'offer.name'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            offers: 'university/availableOffers',
            offersLoading: 'university/availableOffersLoading',
            userUniversities: 'user/userUniversities'
        }),
    },

    methods: {
        ...mapActions({
            fetchOffers: 'university/fetchAvailableOffers',
            fetchUserUniversities: 'user/fetchUserUniversities'
        }),
    },

    created() {
        this.fetchUserUniversities().then(() => {
            this.userUniversities.forEach((university) => {
                this.fetchOffers(university.slug).then(() => {
                    this.allOffers = this.allOffers.concat(this.offers);
                });
            });
        });
    }
}
</script>

<style scoped>

</style>
