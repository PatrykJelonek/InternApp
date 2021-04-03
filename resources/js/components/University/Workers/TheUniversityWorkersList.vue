<template>
    <v-card elevation="0" color="card-background">
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Pracownicy</v-list-item-title>
                    <v-list-item-subtitle>Lista pracowników przynależących do {{
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
                            <span>Dodaj Pracownika</span>
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
                        :items="workers"
                        :items-per-page="5"
                        :loading="workersLoading"
                        class="elevation-1"
                    >
                        <template v-slot:item.fullname="{ item }">
                            {{ item.first_name + ' ' + item.last_name }}
                        </template>
                        <template v-slot:item.rolesChips="{ item }">
                            <v-chip-group>
                                <v-chip
                                label small outlined
                                v-for="role in item.roles"
                                :key="role.id"
                                >{{ role.display_name }}</v-chip>
                            </v-chip-group>
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

export default {
    name: "TheUniversityWorkersList",

    data() {
        return {
            show: true,
            headers: [
                {text: 'Imię i nazwisko', value: 'fullname'},
                {text: 'Role', value: 'rolesChips'},
                {text: 'Akcje', value: 'actions', sortable: false, align: 'center'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            workers: 'university/workers',
            workersLoading: 'university/workersLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchWorkers: 'university/fetchWorkers',
        }),
    },

    created() {
        this.fetchWorkers(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
