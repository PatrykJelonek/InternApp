<template>
    <v-row>
        <v-col cols="12">
            <expand-card
                title="Kategorie ofert"
                description="Lista dostępnych kategorii ofert praktyk"
            >
                <template v-slot:buttons>
                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                small
                                icon
                                v-bind="attrs"
                                v-on="on"
                                @click="fetchOfferCategories">
                                <v-icon>mdi-database-refresh-outline</v-icon>
                            </v-btn>
                        </template>
                        <span>Pobierz kategorie</span>
                    </v-tooltip>
                </template>
                <v-data-table
                    :items="offerCategories"
                    :loading="offerCategoriesLoading"
                    :headers="headers"
                    :items-per-page="5"
                    no-data-text="Załaduj kategorie..."
                >
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
                                    <v-list-item-title>Edytuj kategorie</v-list-item-title>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-title>Usuń kategorie</v-list-item-title>
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
import moment from "moment";

export default {
    name: "TheAdminSettingsOfferCategories",
    components: {ExpandCard},

    data() {
        return {
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Opis', value: 'description'},
                {text: 'Nazwa wyświetlana', value: 'display_name'},
                {text: 'Data utworzenia', value: 'created_at'},
                {text: 'Data modyfikacji', value: 'updated_at'},
                {text: 'Akcje', value: 'actions'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            offerCategories: 'offer/offerCategories',
            offerCategoriesLoading: 'offer/offerCategoriesLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchOfferCategories: 'offer/fetchOfferCategories',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY - HH:mm');
        }
    },
}
</script>

<style scoped>

</style>
