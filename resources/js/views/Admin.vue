<template>
    <v-container fluid v-has="['admin']">
        <v-row>
            <v-col cols="12">
                <router-view></router-view>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import PageTitle from "../components/_Helpers/PageTitle";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Admin",
    components: {PageTitle},

    computed: {
        ...mapGetters({
            numberOfNewOffers: 'statistic/numberOfNewOffers',
            numberOfNewOffersLoading: 'statistic/numberOfNewOffersLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchNewOfferStatuses: 'statistic/fetchNumberOfNewOffers',
        }),
    },

    created() {
        this.fetchNewOfferStatuses().then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
