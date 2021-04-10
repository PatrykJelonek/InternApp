<template>
    <v-card elevation="0" :loading="loading" color="card-background">
        <v-card-title>Praktyki</v-card-title>
        <v-card-subtitle>Ponieżej znajduje się lista praktyk którymi się opiekujesz.</v-card-subtitle>
        <v-divider></v-divider>
        <v-row>
            <v-col cols="12">
                <v-list nav v-if="!loading && internships.length > 0" color="card-background">
                    <dashboard-internships-item
                        v-for="internship in displayedInternships"
                        :key="internship.id"
                        :id="internship.id"
                        :name="internship.offer.name"
                        :company="internship.agreement.company.name"
                        :journal-entries-stats="[]"
                    ></dashboard-internships-item>
                </v-list>
                <v-list v-else color="card-background">
                    <v-list-item>
                        <v-list-item-title class="text-center">{{ emptyInternshipsListMessage }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-col>
            <v-col cols="12" v-if="!loading && internships.length > perPage">
                <v-pagination
                    v-model="page"
                    :length="Math.ceil(internships.length/perPage)"
                    :total-visible="totalVisible"
                ></v-pagination>
            </v-col>
        </v-row>

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
            page: 1,
            perPage: 5,
            totalVisible: 5,
            emptyInternshipsListMessage: 'Ładowanie listy praktyk...'
        }
    },

    computed: {
        ...mapGetters({
            internships: 'user/newInternships',
        }),

        displayedInternships() {
            return this.internships.slice((this.page - 1) * this.perPage, this.page * this.perPage);
        },
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
