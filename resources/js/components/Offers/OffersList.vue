<template>
        <v-card outlined>
            <v-data-table
                :headers="headers"
                :items="offers"
                :items-per-page="10"
                :loading="isLoading"
                @click:row="(item) => {this.$router.push({name: 'offer', params: {id: item.id}})}"
            >
                <template v-slot:item.action="{ item }" v-if="haveRole(['university-worker'])">
                    <v-btn small color="primary" :to="'/create-agreement/'+item.id">Złóż Ofertę</v-btn>
                </template>
            </v-data-table>
        </v-card>
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
                    { text: 'Akcje', value: 'action' },
                ],
            }
        },

        computed: {
            ...mapGetters({
                offers: 'offer/offers',
                roles: 'auth/roles'
            }),
        },

        methods: {
            ...mapActions({
                fetchOffers: 'offer/fetchOffers'
            }),

            haveRole: function (rolesToCheck) {
                let haveRole = false;
                this.roles.forEach((role) => {
                    rolesToCheck.forEach((roleToCheck) => {
                        console.log(`${roleToCheck} vs. ${role} == ${roleToCheck === role}`);
                        if(roleToCheck === role)
                            haveRole = true;
                    });
                });

                return haveRole;
            }
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
