<template>
    <v-card elevation="0" color="card-background">
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Aplikacje na praktyki</v-list-item-title>
                    <v-list-item-subtitle>Oto lista twoich aplikacji na praktyki.</v-list-item-subtitle>
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
                        <template v-slot:item.status="{ item }">
                            <v-chip label outlined small color="primary">{{  getStatusDisplayName(item.status.name) }}</v-chip>
                        </template>
                        <template v-slot:item.created="{ item }">
                            {{ formatDate(item.created_at) }}
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
name: "TheStudentOfferApplicationsList",

    data() {
        return {
            show: true,
            emptyInternshipsListMessage: 'Ładowanie listy praktyk...',
            headers: [
                {text: 'Nazwa', value: 'offer.name'},
                {text: 'Status', value: 'status'},
                {text: 'Data Aplikacji', value: 'created'},
            ]
        }
    },

    computed: {
        ...mapGetters({
            internships: 'user/newInternships',
            internshipsLoading: 'user/newInternshipsLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchInternships: 'user/fetchNewInternships',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },

        getStatusDisplayName(status) {
            switch (status) {
                case 'new':
                    return 'Nowy';
                    break;
                case 'accepted':
                    return 'Zaakceptowany';
                    break;
                default:
                    return status;
                    break;
            }
        },
    },

    created() {
        this.fetchInternships().then(() => {
            this.emptyInternshipsListMessage = 'Aktualnie nie posiadasz żadnych praktyk.'
        }).catch((e) => {
            this.emptyInternshipsListMessage = 'Wystąpił błąd podczas pobierania listy aplikacji na praktyki.'
        });
    }
}
</script>

<style scoped>

</style>
