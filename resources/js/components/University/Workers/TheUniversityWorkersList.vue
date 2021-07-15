<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Lista pracowników</template>
        </custom-card-title>
        <v-row v-show="show" no-gutters>
            <v-col cols="12">
                <v-data-table
                    :headers="headers"
                    :items="workers"
                    :items-per-page="5"
                    :loading="workersLoading"
                    class="elevation-1 component-background"
                >
                    <template v-slot:item.fullname="{ item }">
                        {{ item.full_name }}
                    </template>
                    <template v-slot:item.rolesChips="{ item }">
                        <template v-if="item.universities_with_roles[0].roles.length > 0">
                            <v-chip-group>
                                <v-chip
                                    small
                                    outlined
                                    v-for="role in item.universities_with_roles[0].roles"
                                    :key="role.id"
                                >{{ role.display_name }}
                                </v-chip>
                            </v-chip-group>
                        </template>
                        <template v-else>
                            <span class="text-caption secondary--text">Brak</span>
                        </template>
                    </template>
                    <template v-slot:item.verified="{ item }">
                        <template v-if="item.universities_with_roles[0].verified">
                            <v-icon color="primary" small class="mr-2">mdi-check-decagram-outline</v-icon>
                            Tak
                        </template>
                        <template v-else>
                            <v-icon color="secondary" small class="mr-2">mdi-alert-decagram-outline</v-icon>
                            Nie
                        </template>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-menu offset-y class="component-background">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <v-icon>mdi-dots-vertical</v-icon>
                                </v-btn>
                            </template>
                            <v-list dense color="component-background">
                                <v-list-item class="cursor-pointer">
                                    <v-list-item-title>
                                        Zweryfikuj
                                    </v-list-item-title>
                                </v-list-item>
                                <v-list-item class="cursor-pointer">
                                    <v-list-item-title>
                                        Zmień role
                                    </v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheUniversityWorkersList",
    components: {CustomCardTitle, CustomCard},
    data() {
        return {
            show: true,
            headers: [
                {text: 'Imię i nazwisko', value: 'fullname'},
                {text: 'Role', value: 'rolesChips'},
                {text: 'Zweryfikowany', value: 'verified', sortable: false, align: 'center'},
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
