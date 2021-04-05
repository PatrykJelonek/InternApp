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
                    <v-form class="ma-5">
                        <v-row>
                            <v-col cols="6">
                                <v-text-field
                                    label="Nazwa uczelni"
                                    :value="university.name"
                                    disabled
                                    outlined
                                    hide-details dense
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    label="Typ uczelni"
                                    :value="university.type.name"
                                    disabled
                                    outlined
                                    hide-details dense
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field
                                    label="Adres"
                                    :value="university.street + ' ' + university.street_number + ', ' + university.city.post_code + ' ' + university.city.name "
                                    disabled
                                    outlined
                                    hide-details dense
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <v-text-field
                                    label="Adres email"
                                    :value="university.email"
                                    disabled
                                    outlined
                                    hide-details dense
                                ></v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field
                                    label="Strona internetowa"
                                    :value="university.website"
                                    disabled
                                    outlined
                                    hide-details dense
                                ></v-text-field>
                            </v-col>
                        </v-row>
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
