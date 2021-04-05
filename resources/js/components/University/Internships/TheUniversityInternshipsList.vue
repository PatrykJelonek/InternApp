<template>
    <v-card elevation="0" color="card-background">
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Praktyki i Staże</v-list-item-title>
                    <v-list-item-subtitle>Lista praktyk i staży przypisanych do {{
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
                            <span>Dodaj Praktykę / Staż</span>
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
                        :items="internships"
                        :items-per-page="5"
                        :loading="internshipsLoading"
                        class="elevation-1"
                    >
                        <template v-slot:item.universitySupervisor="{ item }">
                            <router-link :to="{name: 'user', params: {id: item.university_supervisor.id}}">
                                {{ item.university_supervisor.first_name + ' ' + item.university_supervisor.last_name }}
                            </router-link>
                        </template>
                        <template v-slot:item.companySupervisor="{ item }">
                            <router-link :to="{name: 'user', params: {id: item.company_supervisor.id}}">
                                {{ item.company_supervisor.first_name + ' ' + item.company_supervisor.last_name }}
                            </router-link>
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
import {mapActions, mapGetters} from "vuex";
import moment from "moment";

export default {
    name: "TheUniversityInternshipsList",
    data() {
        return {
            show: true,
            headers: [
                {text: 'Nazwa', value: 'offer.name'},
                {text: 'Opiekun z uczelni', value: 'universitySupervisor'},
                {text: 'Opiekun z firmy', value: 'companySupervisor'},
                {text: 'Status', value: 'status.displayed_name'},
                {text: 'Akcje', value: 'actions', sortable: false, align: 'center'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            internships: 'university/internships',
            internshipsLoading: 'university/internshipsLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchInternships: 'university/fetchInternships',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        }
    },

    created() {
        this.fetchInternships(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
