<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="offers"
            :items-per-page="10"
            :loading="isLoading"
            @click:row="(item) => {this.$router.push({name: 'offer', params: {id: item.id}})}"
        ></v-data-table>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "OffersList",

        data() {
            return {
                isLoading: true,
                headers: [
                    { text: 'Nazwa', value: 'name' },
                    { text: 'Ilość miejsc', value: 'places_number' },
                    { text: 'Kategoria', value: 'offer_category.name' },
                    { text: 'Firma', value: 'company.name' },
                    { text: 'Miasto', value: 'company.city.name' },
                ],
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
