<template>
    <v-card elevation="0" color="card-background">
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Umowy</v-list-item-title>
                    <v-list-item-subtitle>Lista umów należących do {{
                            university.name
                        }}.
                    </v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn-toggle borderless dense>
                        <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    small
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <v-icon>mdi-plus</v-icon>
                                </v-btn>
                            </template>
                            <span>Dodaj Umowę</span>
                        </v-tooltip>
                        <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    small
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="show = !show">
                                    <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                                </v-btn>
                            </template>
                            <span>{{ show ? 'Zwiń Listę' : 'Rozwiń Listę' }}</span>
                        </v-tooltip>
                    </v-btn-toggle>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-expand-transition>
            <v-row v-show="show" no-gutters>
                <v-col cols="12">
                    <v-data-table
                        :headers="headers"
                        :items="agreements"
                        :items-per-page="5"
                        :loading="agreementsLoading"
                        class="elevation-1"
                    >
                        <template v-slot:item.company="{ item }">
                            <router-link :to="{name: 'company', params: {slug: item.company.slug}}">{{
                                    item.company.name
                                }}
                            </router-link>
                        </template>
                        <template v-slot:item.universitySupervisor="{ item }">
                            <router-link :to="{name: 'user', params: {id: item.supervisor.id}}">
                                {{ item.supervisor.first_name + ' ' + item.supervisor.last_name }}
                            </router-link>
                        </template>
                        <template v-slot:item.companySupervisor="{ item }">
                            <router-link :to="{name: 'user', params: {id: item.offer.supervisor.id}}">
                                {{ item.offer.supervisor.first_name + ' ' + item.offer.supervisor.last_name }}
                            </router-link>
                        </template>
                        <template v-slot:item.dates="{ item }">
                            {{ formatDate(item.date_from) + ' - ' + formatDate(item.date_to) }}
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-btn icon x-small>
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
import moment from "moment";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "TheUniversityAgreementsList",

    data() {
        return {
            show: true,
            headers: [
                {text: 'Nazwa', value: 'offer.name'},
                {text: 'Firma', value: 'company'},
                {text: 'Opiekun z uczelni', value: 'universitySupervisor'},
                {text: 'Opiekun z firmy', value: 'companySupervisor'},
                {text: 'Okres ważności', value: 'dates'},
                {text: 'Akcje', value: 'actions', sortable: false, align: 'center'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            agreements: 'university/agreements',
            agreementsLoading: 'university/agreementsLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchAgreements: 'university/fetchAgreements',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        }
    },

    created() {
        this.fetchAgreements(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
