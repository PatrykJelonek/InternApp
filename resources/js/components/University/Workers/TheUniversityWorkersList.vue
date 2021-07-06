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
                        {{ item.first_name + ' ' + item.last_name }}
                    </template>
                    <template v-slot:item.rolesChips="{ item }">
                        <v-chip-group>
                            <v-chip
                                label small outlined
                                v-for="role in item.roles"
                                :key="role.id"
                            >{{ role.display_name }}
                            </v-chip>
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
