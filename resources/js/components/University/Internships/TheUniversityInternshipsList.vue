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
                    class="component-background"
                    :search="search"
                    @click:row="(item) => {$router.push({name: 'internship', params: {internshipId: item.id}})}"
                >
                    <template v-slot:item.university_supervisor.full_name="{ item }">
                        <router-link :to="{name: 'user', params: {id: item.university_supervisor.id}}">
                            {{ item.university_supervisor.full_name }}
                        </router-link>
                    </template>
                    <template v-slot:item.company_supervisor.full_name="{ item }">
                        <router-link :to="{name: 'user', params: {id: item.company_supervisor.id}}">
                            {{ item.company_supervisor.full_name }}
                        </router-link>
                    </template>
                    <template v-slot:item.agreement.date_from="{ item }">
                        {{ item.agreement.date_from }}
                    </template>
                    <template v-slot:item.agreement.date_to="{ item }">
                        {{ item.agreement.date_to }}
                    </template>
                    <template v-slot:item.status.display_name="{ item }">
                        <v-chip small outlined :color="item.status.hex_color">{{ item.status.display_name }}</v-chip>
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
                            <v-list dense color="component-background" class="cursor-pointer">
                                <v-list-item>
                                    <v-list-item-title @click="$router.push({name: 'internship', params: {internshipId: item.id}})">
                                        Zobacz praktykę
                                    </v-list-item-title>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-title @click="$router.push({name: 'agreement', params: {slug: item.agreement.slug}})">
                                        Zobacz umowę
                                    </v-list-item-title>
                                </v-list-item>
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

    props: ['search'],

    data() {
        return {
            show: true,
            headers: [
                {text: 'Nazwa', value: 'offer.name'},
                {text: 'Opiekun z uczelni', value: 'university_supervisor.full_name'},
                {text: 'Opiekun z firmy', value: 'company_supervisor.full_name'},
                {text: 'Data rozpoczęcia', value:'agreement.date_from'},
                {text: 'Data zakończenia', value:'agreement.date_to'},
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
    .cursor-pointer {
        cursor: pointer;
    }
</style>
