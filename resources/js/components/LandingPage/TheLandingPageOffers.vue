<template>
    <v-container>
        <v-row class="my-15">
            <v-col cols="12" class="text-center">
                <h3 class="text-h4 text-md-h3 font-weight-bold text-uppercase">Najnowsze Oferty Praktyk</h3>
            </v-col>
        </v-row>
        <v-row v-if="offersLoading && offers.length > 0" class="mb-15">
            <v-col cols="12" class="d-flex justify-center">
                <v-progress-circular color="green accent-4" size="60" indeterminate></v-progress-circular>
            </v-col>
        </v-row>
        <v-row v-else class="mb-10">
            <v-slide-group
                v-model="slider"
                show-arrows
                center-active
                mandatory
            >
                <v-slide-item
                    v-for="offer in offers"
                    :key="offer.id"
                    v-slot="{ active, toggle }"
                >
                    <v-fade-transition>
                        <v-card elevation="0" width="300px" class="mx-5 my-10 grey lighten-3">
                            <v-card-subtitle class="my-0 py-0">
                                <a class="green--text text--accent-4 font-weight-bold text-decoration-none" :href="offer.company.website">
                                    {{offer.company.name}}
                                </a>
                            </v-card-subtitle>
                            <v-card-title class="mt-0 pt-0 text-h6 font-weight-bold text-uppercase text-break">{{ offer.name }}</v-card-title>
                            <v-card-text class="mt-3 text--secondary">{{ offer.program.substring(0, 64) }} {{ offer.program.length > 64 ? '...' : ''}}</v-card-text>
                        </v-card>
                    </v-fade-transition>
                </v-slide-item>
                <v-slide-item v-if="offers.length > 9">
                    <v-card elevation="0" width="300px" class="mx-5 my-10 d-flex justify-start align-self-center">
                        <v-btn
                            outlined
                            color="green accent-4"
                            :to="{name: 'login'}"
                        >
                            Zobacz więcej
                        </v-btn>
                    </v-card>
                </v-slide-item>
            </v-slide-group>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "TheLandingPageOffers",

    data() {
        return {
            slider: null,
        }
    },

    methods: {
        ...mapActions({
            fetchOffers: 'landingPage/fetchOffers'
        }),
    },

    computed: {
        ...mapGetters({
            offers: 'landingPage/offers',
            offersLoading: 'landingPage/offersLoading',
        }),
    },

    created() {
        this.fetchOffers().then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
