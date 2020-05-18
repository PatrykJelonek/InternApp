<template>
    <v-container fluid class="pa-10" v-bind:class="{ 'fill-height': userUniversities.length == 0 }">
        <v-row v-if="userUniversities.length > 0" class="d-flex flex-column px-5">
            <v-row class="d-flex align-center justify-space-between">
                <v-col class="pa-0">
                    <h2 class="text-uppercase title font-weight-black grey--text text--darken-4">Zarządzaj Uczelnią</h2>
                </v-col>
                <v-col cols="4">
                    <v-select
                        v-model="chosenUniversity"
                        :items="userUniversities"
                        item-text="name"
                        item-value="id"
                        label="Wybierz Uniwersytet"
                        outlined
                        dense
                        hide-details
                    ></v-select>
                </v-col>
            </v-row>
        </v-row>
        <v-row class="d-flex" v-else>
            <v-col cols="12">
                <universities-not-found></universities-not-found>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters, mapState} from "vuex";
    import UniversitiesNotFound from "../components/Universities/UniversitiesNotFound";

    export default {
        name: "Universities",
        components: {UniversitiesNotFound},
        data() {
            return {
                chosenUniversity: 'a',
            }
        },

        computed: {
            ...mapGetters({
                userUniversities: 'user/userUniversities',
            }),
        },

        methods: {
            ...mapActions({
                fetchUserUniversities: 'user/fetchUserUniversities',
            }),
        },

        created() {
            this.fetchUserUniversities().then(() => {
                this.chosenUniversity = this.userUniversities[0];
            });
        },
    }
</script>

<style scoped>

</style>
