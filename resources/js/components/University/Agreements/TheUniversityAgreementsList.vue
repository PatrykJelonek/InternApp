<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Umowy</template>
            <template v-slot:subheader>Lista umów przypisanych do {{
                    !universityLoading ? university.name : 'tej uczelni'
                }}
            </template>
        </page-title>
        <v-row>
            <create-own-agreement-dialog></create-own-agreement-dialog>
            <v-col cols="12">
                <custom-card>
                    <custom-card-title>
                        <template v-slot:default>Lista umów</template>
                    </custom-card-title>
                    <template v-slot:buttons>
                        <v-tooltip top v-has="['deanery_worker']">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    small
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="toggleCreateOwnAgreementDialog(true)"
                                >
                                    <v-icon>mdi-plus</v-icon>
                                </v-btn>
                            </template>
                            <span>Dodaj Umowę</span>
                        </v-tooltip>
                    </template>
                    <v-data-table
                        :headers="headers"
                        :items="agreements"
                        :items-per-page="5"
                        :loading="agreementsLoading"
                        class="elevation-1 component-background"
                    >
                        <template v-slot:item.company="{ item }">
                            <router-link :to="{name: 'company', params: {slug: item.company.slug}}">{{
                                    item.company.name
                                }}
                            </router-link>
                        </template>
                        <template v-slot:item.universitySupervisor="{ item }">
                            <router-link :to="{name: 'user', params: {id: item.supervisor.id}}">
                                {{ item.supervisor.first_name + ' ' + item.supervisor.last_name }}
                            </router-link>
                        </template>
                        <template v-slot:item.companySupervisor="{ item }">
                            <router-link :to="{name: 'user', params: {id: item.offer.supervisor.id}}">
                                {{ item.offer.supervisor.first_name + ' ' + item.offer.supervisor.last_name }}
                            </router-link>
                        </template>
                        <template v-slot:item.dates="{ item }">
                            {{ formatDate(item.date_from) + ' - ' + formatDate(item.date_to) }}
                        </template>
                        <template v-slot:item.is_active="{ item }">
                            <v-chip
                                small
                                :color="item.is_active  ? '#C8E6C9' : 'grey lighten-3'"
                            >
                                {{ item.is_active ? 'Aktywna' : 'Nieaktywna' }}
                            </v-chip>
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
                                        <v-list-item-title class="link">Odrzuć</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </template>
                    </v-data-table>
                </custom-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import moment from "moment";
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";
import CreateOwnAgreementDialog from "./CreateOwnAgreementDialog";
import PageTitle from "../../_Helpers/PageTitle";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheUniversityAgreementsList",
    components: {CustomCardTitle, CustomCard, PageTitle, CreateOwnAgreementDialog, ExpandCard},
    data() {
        return {
            show: true,
            headers: [
                {text: 'Nazwa', value: 'offer.name'},
                {text: 'Firma', value: 'company'},
                {text: 'Opiekun z uczelni', value: 'universitySupervisor'},
                {text: 'Opiekun z firmy', value: 'companySupervisor'},
                {text: 'Okres ważności', value: 'dates'},
                {text: 'Status', value: 'is_active'},
                {text: 'Akcje', value: 'actions', sortable: false, align: 'center'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            universityLoading: 'university/universityLoading',
            agreements: 'university/agreements',
            agreementsLoading: 'university/agreementsLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchAgreements: 'university/fetchAgreements',
            toggleCreateOwnAgreementDialog: 'helpers/toggleCreateOwnAgreementDialog',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        }
    },

    created() {
        this.fetchAgreements(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style lang="scss" scoped>

</style>
