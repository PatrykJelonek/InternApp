<template>
    <v-card elevation="0" color="card-background">
        <template slot="progress">
            <v-progress-linear color="primary" indeterminate></v-progress-linear>
        </template>
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Dane o uczelni
                    </v-list-item-title>
                    <v-list-item-subtitle>Dane o uczelni {{
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
                                    @click="show = !show"
                                color="card-background"
                                >
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
                    <v-form>
                        <v-tabs v-model="tabs" background-color="card-background">
                            <v-tab>
                                Dane Ogólne
                            </v-tab>
                            <v-tab>
                               Dane Adresowe
                            </v-tab>
                            <v-tab>
                                Dane Kontaktowe
                            </v-tab>
                            <v-tabs-items  v-model="tabs" class="ma-1 pa-5 card-background">
                                <v-tab-item>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                label="Nazwa uczelni"
                                                :value="university.name"
                                                readonly
                                                hide-details
                                                outlined
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                label="Typ uczelni"
                                                :value="university.type.name"
                                                readonly
                                                hide-details
                                                outlined
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-tab-item>
                                <v-tab-item>
                                    <v-row>
                                        <v-col cols="8">
                                            <v-text-field
                                                label="Ulica"
                                                :value="university.street"
                                                readonly
                                                outlined
                                                hide-details
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-text-field
                                                label="Numer Budynku"
                                                :value="university.street_number"
                                                readonly
                                                outlined
                                                hide-details
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="3">
                                            <v-text-field
                                                label="Kod Pocztowy"
                                                :value="university.city.post_code"
                                                readonly
                                                outlined
                                                hide-details
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-text-field
                                                label="Miasto"
                                                :value="university.city.name"
                                                readonly
                                                outlined
                                                hide-details
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-tab-item>
                                <v-tab-item>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                label="Adres email"
                                                :value="university.email"
                                                readonly
                                                outlined
                                                hide-details
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                label="Strona internetowa"
                                                :value="university.website"
                                                readonly
                                                outlined
                                                hide-details
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                label="Numer telefonu"
                                                :value="university.phone"
                                                readonly
                                                outlined
                                                hide-details
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-tab-item>
                            </v-tabs-items>
                        </v-tabs>
                    </v-form>
                </v-col>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";

export default {
    name: "TheUniversitySettingsForm",

    data() {
        return {
            show: true,
            tabs: null,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
        }),
    },

    methods: {
        ...mapActions({}),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        }
    },
}
</script>

<style scoped>

</style>
