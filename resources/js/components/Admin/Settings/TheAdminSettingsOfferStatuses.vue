<template>
    <v-row>
        <v-col cols="12">
            <expand-card
                title="Statusy ofert"
                description="Lista dostępnych statusów ofert praktyk"
            >
                <template v-slot:buttons>
                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                small
                                icon
                                v-bind="attrs"
                                v-on="on"
                                @click="fetchOfferStatuses">
                                <v-icon>mdi-database-refresh-outline</v-icon>
                            </v-btn>
                        </template>
                        <span>Pobierz kategorie</span>
                    </v-tooltip>
                </template>
                <v-data-table
                    :items="offerStatuses"
                    :loading="offerStatusesLoading"
                    :headers="headers"
                    :items-per-page="10"
                    no-data-text="Pobierz statusy"
                    group-by="group"
                >
                    <template v-slot:group.header="{ group, toggle, headers, isOpen }">
                        <th v-bind:colspan="headers.length">
                            {{ getStatusDisplayName(group) }}
                            <v-btn icon >
                                <v-icon @click="toggle">{{ isOpen ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                            </v-btn>
                        </th>
                    </template>
                    <template v-slot:item.hex_color="{ item }">
                        <v-chip
                            small
                            :color="item.hex_color"
                        >
                            {{ item.hex_color }}
                        </v-chip>
                    </template>
                    <template v-slot:item.created_at="{ item }">
                        {{ formatDate(item.created_at) }}
                    </template>
                    <template v-slot:item.updated_at="{ item }">
                        {{ formatDate(item.updated_at) }}
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-menu offset-y>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <v-icon>mdi-dots-vertical</v-icon>
                                </v-btn>
                            </template>
                            <v-list dense>
                                <v-list-item>
                                    <v-list-item-title>Edytuj status</v-list-item-title>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-title>Usuń status</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </template>
                </v-data-table>
            </expand-card>
        </v-col>
    </v-row>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import moment from 'moment';

export default {
    name: "TheAdminSettingsOfferStatuses",
    components: {ExpandCard},

    data() {
        return {
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Opis', value: 'description'},
                {text: 'Nazwa wyświetlana', value: 'display_name'},
                {text: 'Kolor', value: 'hex_color'},
                {text: 'Data utworzenia', value: 'created_at'},
                {text: 'Data modyfikacji', value: 'updated_at'},
                {text: 'Akcje', value: 'actions'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            offerStatuses: 'offer/offerStatuses',
            offerStatusesLoading: 'offer/offerStatusesLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchOfferStatuses: 'offer/fetchOfferStatuses',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY - HH:mm');
        },

        getStatusDisplayName(item) {
            switch (item) {
                case 'new':
                    return 'Nowe';
                case 'accepted':
                    return 'Zaakceptowane';
                case 'rejected':
                    return 'Odrzucone';
                default:
                    return 'Niezgrupowany';
            }
        },
    },

    created() {

    }
}
</script>

<style scoped>

</style>
