<template>
    <v-card elevation="0" :loading="loading">
        <v-card-title>Praktyki</v-card-title>
        <v-card-subtitle>Ponieżej znajduje się lista praktyk którymi się opiekujesz.</v-card-subtitle>
        <v-divider></v-divider>
        <v-list nav v-if="!loading && internships.length > 0">
            <dashboard-internships-item
                v-for="internship in internships"
                :key="internship.id"
                :id="internship.id"
                :name="internship.offer.name"
                :company="internship.agreement.company.name"
                :journal-entries-stats="[]"
            ></dashboard-internships-item>
        </v-list>
        <v-list v-else>
            <v-list-item>
                <v-list-item-title class="text-center">{{ emptyInternshipsListMessage }}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-card>
</template>

<script>
import DashboardInternshipsItem from "./DashboardInternshipsItem";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "TheDashboardInternships",
    components: {DashboardInternshipsItem},

    data() {
        return {
            loading: true,
            emptyInternshipsListMessage: 'Ładowanie listy praktyk...'
        }
    },

    computed: {
        ...mapGetters({
            internships: 'user/newInternships',
        })
    },

    methods: {
        ...mapActions({
            fetchInternships: 'user/fetchNewInternships'
        }),
    },

    created() {
        this.fetchInternships().then(() => {
            this.loading = false;
            this.emptyInternshipsListMessage = 'Aktualnie nie posiadasz żadnych praktyk.'
        }).catch((e) => {
            this.emptyInternshipsListMessage = 'Wystąpił błąd podczas pobierania listy praktyk.'
        });
    }
}
</script>

<style scoped>

</style>
