<template>
    <div>
        <h2 class="pb-5">Universities</h2>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="this.universities"
                :items-per-page="5"
                :no-data-text="noDataText"
                class="elevation-1"
            ></v-data-table>
        </v-card>
    </div>
</template>

<script>
    import {mapState} from "vuex";
    import store from "../store";

    export default {
        name: "Universities",
        data() {
            return {
                noDataText: "Niestety nie ma jeszcze żadnych uniwersytetów!",
                headers: [
                    {
                        text: "Nazwa",
                        align: 'start',
                        sortable: true,
                        value: 'name'
                    },
                    { text: "Email kontaktowy", value: 'email' },
                    { text: "Stron internetowa", value: 'website' },
                ],
            }
        },
        computed: {
            ...mapState({
                universities: state => state.university.universities,
            }),
        },
        created: function () {
            store.dispatch('fetchUniversitiesFromApi');
        }
    }
</script>

<style scoped>

</style>
