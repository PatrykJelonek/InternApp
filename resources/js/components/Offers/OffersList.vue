<template>
    <v-card elevation="0" color="card-background">
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Oferty</v-list-item-title>
                    <v-list-item-subtitle>Lista ofert udostępnionych przez firmy.</v-list-item-subtitle>
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

                </v-col>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "OffersList",

        data() {
            return {
                show: true,
            }
        },

        computed: {
            ...mapGetters({
                offers: 'offer/offers',
            }),
        },

        methods: {
            ...mapActions({
                fetchOffers: 'offer/fetchOffers'
            }),
        },

        created() {
            this.fetchOffers().then(() => {
                this.isLoading = false;
            });
        }
    }
</script>

<style scoped>

</style>
