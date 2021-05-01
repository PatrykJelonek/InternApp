<template>
    <v-container>
        <v-row v-if="!offerLoading">
            <v-col cols="12">
                <page-title>{{ offer.name }}</page-title>
            </v-col>
        </v-row>
        <v-row v-else class="text-center">
            <v-col cols="12">
                <page-loader></page-loader>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import PageTitle from "../components/_Helpers/PageTitle";
    import PageLoader from "../components/_General/PageLoader";

    export default {
        name: "Offer",
        components: {PageLoader, PageTitle, PageDetailsHeader},
        data() {
            return {
                tab: null,
            }
        },

        computed: {
            ...mapGetters({
                offer: 'offer/offer',
                offerLoading: 'offer/offerLoading',
            }),
        },

        methods: {
            ...mapActions({
                fetchOffer: 'offer/fetchOffer'
            }),

            toCompany() {
                return this.$router.push({name: 'company', params: {id: this.offer.company.id}})
            },
        },

        created() {
            this.fetchOffer(this.$route.params.slug).then(() => {

            }).catch((e) => {

            });
        }
    }
</script>

<style scoped>
    .detail_header {
        height: 200px;
    }
</style>
