<template>
    <v-container fluid>
        <apply-internship-dialog :agreement="agreement" v-if="!agreementLoading"></apply-internship-dialog>

        <page-title v-if="!agreementLoading">
            <template v-slot:default>{{ agreement.name }}</template>
            <template v-slot:actions v-if="agreement.places_number > 0">
                <v-btn color="primary" outlined @click="toggleApplyInternshipDialog(true)">Aplikuj</v-btn>
            </template>
        </page-title>

        <v-row v-if="!agreementLoading">
            <v-col cols="12" lg="4">
                <expand-card
                    title="Miejsce praktyk"
                    description="Informacje na temat miejsca odbywania praktyki."
                    :expand="false"
                >
                    <v-list class="component-background">
                        <v-row>
                            <v-col cols="6">
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Firma</v-list-item-title>
                                        <v-list-item-subtitle>{{ agreement.company.name }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Adres</v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ agreement.company.street + ' ' + agreement.company.street_number + ', ' + agreement.company.city.name + ' ' + agreement.company.city.post_code }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-col>
                            <v-col cols="6">
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Email</v-list-item-title>
                                        <v-list-item-subtitle>{{ agreement.company.email }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Website</v-list-item-title>
                                        <v-list-item-subtitle>{{ agreement.company.website }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-col>
                        </v-row>
                    </v-list>
                </expand-card>
            </v-col>
            <v-col cols="12" md="12" lg="8">
                <expand-card
                    title="Informacje"
                    description="Podstawowe informacje na temat praktyki"
                    :expand="false"
                >
                    <v-list class="component-background">
                        <v-row>
                            <v-col cols="4">
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Uczelnia</v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ agreement.university.name }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Opiekun z uczelni</v-list-item-title>
                                        <v-list-item-subtitle>{{ agreement.supervisor.first_name + ' ' + agreement.supervisor.last_name }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-col>
                            <v-col cols="4">
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Liczba miejsc</v-list-item-title>
                                        <v-list-item-subtitle>{{ agreement.places_number }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Data</v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ formatDate(agreement.date_from) + ' - ' + formatDate(agreement.date_to) }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-col>
                            <v-col cols="4">
                                <v-list-item two-line v-if="agreement.offer">
                                    <v-list-item-content >
                                        <v-list-item-title>Interview</v-list-item-title>
                                        <v-list-item-subtitle>
                                            <v-chip  small :color="agreement.offer.interview ? '#C8E6C9' : 'grey lighten-3'">
                                                {{ agreement.offer.interview ? 'Wymagane' : 'Niewymagane' }}
                                            </v-chip>
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item two-line  v-if="agreement.offer">
                                    <v-list-item-content>
                                        <v-list-item-title>Kategoria</v-list-item-title>
                                        <v-list-item-subtitle>{{ agreement.offer.category.display_name }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-col>
                        </v-row>
                    </v-list>
                </expand-card>
            </v-col>
            <v-col cols="12" :xl="agreement.schedule !== null ? '6' : '12'">
                <expand-card title="Program praktyk" :expand="false">
                    <v-row>
                        <v-col cols="12" class="pa-7">{{ agreement.program }}</v-col>
                    </v-row>
                </expand-card>
            </v-col>
            <v-col cols="12" xl="6" v-if="agreement.schedule !== null">
                <expand-card title="Harmonogram praktyk" :expand="false">
                    <v-row>
                        <v-col cols="12" class="pa-7">{{ agreement.schedule }}</v-col>
                    </v-row>
                </expand-card>
            </v-col>
            <v-col
                cols="12" xl="4"
                v-if="agreement.content !== null"
                v-has="['admin','university_worker','university_owner','university_supervisor','deanery_worker']"
            >
                <expand-card title="Treść umowy" :expand="false">
                    <v-row>
                        <v-col cols="12" class="pa-7">{{ agreement.content }}</v-col>
                    </v-row>
                </expand-card>
            </v-col>
        </v-row>
        <v-row v-else class="text-center">
            <v-col cols="12">
                <page-loader></page-loader>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import ExpandCard from "../components/_Helpers/ExpandCard";
    import PageLoader from "../components/_General/PageLoader";
    import PageTitle from "../components/_Helpers/PageTitle";
    import moment from "moment";
    import ApplyInternshipDialog from "../components/Offers/Student/ApplyInternshipDialog";
    export default {
        name: "Agreement",

        components: {ApplyInternshipDialog, PageTitle, PageLoader, ExpandCard},

        data() {
            return {

            }
        },

        computed: {
            ...mapGetters({
                company: 'company/company',
                agreement: 'agreement/agreement',
                agreementLoading: 'agreement/agreementLoading'
            }),
        },

        methods: {
            ...mapActions({
                setBreadcrumbs: 'helpers/setBreadcrumbs',
                fetchAgreement: 'agreement/fetchAgreement',
                activeAgreement: 'agreement/activeAgreement',
                setSnackbar: 'snackbar/setSnackbar',
                toggleApplyInternshipDialog: 'helpers/toggleApplyInternshipDialog',
            }),

            toCompany() {
                return this.$router.push({name: 'company', params: {id: this.agreement.company.id}})
            },

            //TODO: Dodać widok uczelni
            toUniversity() {
                return this.$router.push({name: 'company', params: {id: this.agreement.company.id}})
            },

            formatDate(date) {
                if (date) {
                    return moment(date).format('DD.MM.YYYY');
                }

                return '---';
            },
        },

        created() {
            this.fetchAgreement(this.$route.params.slug).then(() => {
                this.setBreadcrumbs([
                    {text: 'Panel', to: {name: 'panel'}, exact: true},
                    {text: this.agreement.company.name, to: {name: 'company', params: {slug: this.agreement.company.slug}}, exact: true},
                    {text: 'Umowy', to: {name: 'company-agreements', params: {slug: this.agreement.company.slug}}, exact: true},
                    {text: this.agreement.name, to: {name: 'agreement', params: {slug: this.$route.params.slug}}, exact: true},
                ])
            }).catch((e) => {

            });
        },
    }
</script>

<style scoped>

</style>
