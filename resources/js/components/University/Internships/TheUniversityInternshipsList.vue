<template>
    <custom-card>
        <the-university-internship-change-status-dialog></the-university-internship-change-status-dialog>
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
                    no-data-text="Niestety, ta uczelnia nie posiada jeszcze praktyk, ani staży!"
                    loading-text="Pobieranie listy praktyk i staży..."
                    class="elevation-1 component-background"
                    @click:row="(item) => {$router.push({name: 'internship', params: {internshipId: item.id}})}"
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
                    <template v-slot:item.startDate="{ item }">
                        {{ formatDate(item.agreement.date_from) }}
                    </template>
                    <template v-slot:item.endDate="{ item }">
                        {{ formatDate(item.agreement.date_to) }}
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
                                <v-list-item>
                                    <v-list-item-title @click="openChangeStatusDialog(item)">
                                        Zmień status
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
import moment from "moment";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import TheUniversityInternshipChangeStatusDialog from "./TheUniversityInternshipChangeStatusDialog";

export default {
    name: "TheUniversityInternshipsList",
    components: {TheUniversityInternshipChangeStatusDialog, CustomCardTitle, CustomCard},
    data() {
        return {
            show: true,
            headers: [
                {text: 'Nazwa', value: 'offer.name'},
                {text: 'Opiekun z uczelni', value: 'universitySupervisor'},
                {text: 'Opiekun z firmy', value: 'companySupervisor'},
                {text: 'Data rozpoczęcia', value:'startDate'},
                {text: 'Data zakończenia', value:'endDate'},
                {text: 'Status', value: 'status.display_name'},
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
            toggleDialog: 'helpers/toggleDialog',
            setDialogArgs: 'helpers/setDialogArgs',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },

        openChangeStatusDialog(item) {
            this.setDialogArgs({
                key: 'DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS', val: {
                    name: item.offer.name,
                    id: item.id,
                }
            })
            this.toggleDialog({key: 'DIALOG_FIELD_CHANGE_INTERNSHIP_STATUS', val: true});
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
