<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" class="text-right">
                <v-btn color="primary" small @click="refreshStatistics" outlined>
                    Odśwież
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="6" md="4" lg="3" xl="2">
                <v-card elevation="0" color="card-background" :loading="numberOfOffersLoading" @dblclick="fetchNumberOfOffers">
                    <template slot="progress">
                        <v-progress-linear color="primary" indeterminate></v-progress-linear>
                    </template>
                    <v-card-subtitle>Oferty Praktyk</v-card-subtitle>
                    <v-card-title>{{ numberOfOffers }}</v-card-title>
                </v-card>
            </v-col>
            <v-col cols="6" md="4" lg="3" xl="2">
                <v-card elevation="0" color="card-background" :loading="numberOfAgreementsLoading" @dblclick="fetchNumberOfAgreements">
                    <template slot="progress">
                        <v-progress-linear color="primary" indeterminate></v-progress-linear>
                    </template>
                    <v-card-subtitle>Umowy</v-card-subtitle>
                    <v-card-title>{{ numberOfAgreements }}</v-card-title>
                </v-card>
            </v-col>
            <v-col cols="6" md="4" lg="3" xl="2">
                <v-card elevation="0" color="card-background" :loading="numberOfUsersLoading" @dblclick="fetchNumberOfUsers">
                    <template slot="progress">
                        <v-progress-linear color="primary" indeterminate></v-progress-linear>
                    </template>
                    <v-card-subtitle>Użytkownicy</v-card-subtitle>
                    <v-card-title>{{ numberOfUsers }}</v-card-title>
                </v-card>
            </v-col>
            <v-col cols="6" md="4" lg="3" xl="2">
                <v-card elevation="0" color="card-background" :loading="numberOfUniversitiesLoading" @dblclick="fetchNumberOfUniversities">
                    <template slot="progress">
                        <v-progress-linear color="primary" indeterminate></v-progress-linear>
                    </template>
                    <v-card-subtitle>Uniwersytety</v-card-subtitle>
                    <v-card-title>{{ numberOfUniversities }}</v-card-title>
                </v-card>
            </v-col>
            <v-col class="elevation-0" cols="6" md="4" lg="3" xl="2">
                <v-card elevation="0" color="card-background" :loading="numberOfCompaniesLoading" @dblclick="fetchNumberOfCompanies">
                    <template slot="progress">
                        <v-progress-linear color="primary" indeterminate></v-progress-linear>
                    </template>
                    <v-card-subtitle>Firmy</v-card-subtitle>
                    <v-card-title>{{ numberOfCompanies }}</v-card-title>
                </v-card>
            </v-col>

        </v-row>
        <v-row>
            <v-col cols="12">
                <v-subheader>Załączniki</v-subheader>
            </v-col>
            <v-col cols="6" md="4" lg="3" xl="2">
                <v-card elevation="0" color="card-background" :loading="numberOfAttachmentsLoading" @dblclick="fetchNumberOfAttachments">
                    <template slot="progress">
                        <v-progress-linear color="primary" indeterminate></v-progress-linear>
                    </template>
                    <v-card-subtitle>Załączniki (ogółem)</v-card-subtitle>
                    <v-card-title>{{ numberOfAttachments ? numberOfAttachments : 0 }}</v-card-title>
                </v-card>
            </v-col>
            <v-col cols="6" md="4" lg="3" xl="2">
                <v-card elevation="0" color="card-background" :loading="numberOfOffersAttachmentsLoading" @dblclick="fetchNumberOfOffersAttachments">
                    <template slot="progress">
                        <v-progress-linear color="primary" indeterminate></v-progress-linear>
                    </template>
                    <v-card-subtitle>Załączniki do Ofert</v-card-subtitle>
                    <v-card-title>{{ numberOfOffersAttachments ? numberOfOffersAttachments : 0 }}</v-card-title>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "TheAdminStatistics",

    computed: {
        ...mapGetters({
            numberOfOffers: 'statistic/numberOfOffers',
            numberOfOffersLoading: 'statistic/numberOfOffersLoading',
            numberOfAgreements: 'statistic/numberOfAgreements',
            numberOfAgreementsLoading: 'statistic/numberOfAgreementsLoading',
            numberOfUsers: 'statistic/numberOfUsers',
            numberOfUsersLoading: 'statistic/numberOfUsersLoading',
            numberOfUniversities: 'statistic/numberOfUniversities',
            numberOfUniversitiesLoading: 'statistic/numberOfUniversitiesLoading',
            numberOfCompanies: 'statistic/numberOfCompanies',
            numberOfCompaniesLoading: 'statistic/numberOfCompaniesLoading',
            numberOfAttachments: 'statistic/numberOfAttachments',
            numberOfAttachmentsLoading: 'statistic/numberOfAttachmentsLoading',
            numberOfOffersAttachments: 'statistic/numberOfOffersAttachments',
            numberOfOffersAttachmentsLoading: 'statistic/numberOfOffersAttachmentsLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchNumberOfOffers: 'statistic/fetchNumberOfOffers',
            fetchNumberOfAgreements: 'statistic/fetchNumberOfAgreements',
            fetchNumberOfUsers: 'statistic/fetchNumberOfUsers',
            fetchNumberOfUniversities: 'statistic/fetchNumberOfUniversities',
            fetchNumberOfCompanies: 'statistic/fetchNumberOfCompanies',
            fetchNumberOfAttachments: 'statistic/fetchNumberOfAttachments',
            fetchNumberOfOffersAttachments: 'statistic/fetchNumberOfOffersAttachments',
        }),

        refreshStatistics() {
            this.fetchNumberOfOffers();
            this.fetchNumberOfAgreements();
            this.fetchNumberOfUsers();
            this.fetchNumberOfUniversities();
            this.fetchNumberOfCompanies();
            this.fetchNumberOfAttachments();
            this.fetchNumberOfOffersAttachments();
        },
    },

    created() {
        this.fetchNumberOfOffers();
        this.fetchNumberOfAgreements();
        this.fetchNumberOfUsers();
        this.fetchNumberOfUniversities();
        this.fetchNumberOfCompanies();
        this.fetchNumberOfAttachments();
        this.fetchNumberOfOffersAttachments();
    }
}
</script>

<style scoped>

</style>
