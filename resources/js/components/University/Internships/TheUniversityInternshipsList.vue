<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Lista praktyk i staży</template>
        </custom-card-title>
        <v-row v-show="show" no-gutters>
            <v-col cols="12">
                <v-data-table
                    :headers="headers"
                    :items="internships"
                    :items-per-page="5"
                    :loading="internshipsLoading"
                    class="elevation-1 component-background"
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
    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheUniversityInternshipsList",
    components: {CustomCardTitle, CustomCard},
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
