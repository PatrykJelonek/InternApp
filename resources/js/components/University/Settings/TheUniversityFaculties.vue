<template>
    <v-card elevation="0" color="card-background" :loading="facultiesLoading && dataLoading">
        <template slot="progress">
            <v-progress-linear color="primary" indeterminate></v-progress-linear>
        </template>
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Wydziały, kierunki i specjalności
                    </v-list-item-title>
                    <v-list-item-subtitle>Lista wydziałów, kierunków i specjalności przypisanych do {{
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
                            <span>Dodaj Wydział</span>
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
                    <v-treeview :items="data">
                        <template v-slot:append="{ item, open }">
                            <v-tooltip top>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        icon
                                        small
                                        v-bind="attrs"
                                        v-on="on"
                                        v-if="item.type !== 'specialization'">
                                        <v-icon>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                <span>Dodaj {{ item.type === 'faculty' ? 'Kierunek' : 'Specjalność' }}</span>
                            </v-tooltip>
                        </template>
                    </v-treeview>
                </v-col>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";

export default {
    name: "TheUniversityFaculties",

    data() {
        return {
            show: true,
            data: [],
            dataLoading: true,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            faculties: 'university/faculties',
            facultiesLoading: 'university/facultiesLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchFaculties: 'university/fetchFaculties',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        }
    },

    created() {
        this.fetchFaculties(this.$route.params.slug).then(() => {
            this.dataLoading = true;
            this.faculties.forEach((faculty) => {
                let fields = [];
                faculty.fields.forEach((field) => {
                    let specializations = [];
                    field.specializations.forEach((specialization) => {
                        specializations.push({
                            id: specialization.id,
                            name: specialization.name,
                            type: 'specialization'
                        })
                    });
                    fields.push({
                        id: field.id,
                        name: field.name,
                        children: specializations,
                        type: 'field'
                    });
                });
                this.data.push({
                    id: faculty.id,
                    name: faculty.name,
                    type: 'faculty',
                    children: fields,
                });
            });
            this.dataLoading = false;
        }).catch((e) => {
            console.error(e);
        });
    }
}
</script>

<style scoped>

</style>
