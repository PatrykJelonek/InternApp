<template>
    <v-row no-gutters>
        <accept-agreement-dialog :slug="selectedAgreement.slug"></accept-agreement-dialog>
        <reject-agreement-dialog :slug="selectedAgreement.slug"></reject-agreement-dialog>
        <v-col cols="12">
            <expand-card
                title="Lista umów"
                description="Poniżej znajduje się lista umów firmy z uczelniami."
                class="mt-10"
            >
                <v-data-table
                    :items="companyAgreements"
                    :loading="companyAgreementsLoading"
                    :headers="headers"
                >
                    <template v-slot:item.status="{ item }">
                        <v-chip small :color="item.status.hex_color">
                            {{ item.status.display_name }}
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
                                    <v-list-item-title
                                        class="cursor-pointer"
                                        :to="{name: 'offer', params: {slug: item.offer.slug}}"
                                    >
                                        Wyświetl ofertę
                                    </v-list-item-title>
                                </v-list-item>
                                <v-divider v-if="item.status.group === 'new'"></v-divider>
                                <v-list-item v-if="item.status.group === 'new'" @click="accept(item)">
                                    <v-list-item-title class="cursor-pointer">Akceptuj</v-list-item-title>
                                </v-list-item>
                                <v-list-item v-if="item.status.group === 'new'" @click="reject(item)">
                                    <v-list-item-title class="cursor-pointer">Odrzuć</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </template>
                </v-data-table>
            </expand-card>
        </v-col>
    </v-row>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import AcceptAgreementDialog from "../../Agreements/AcceptAgreementDialog";
import RejectAgreementDialog from "../../Agreements/RejectAgreementDialog";

export default {
    name: "TheCompanyAgreements",
    components: {RejectAgreementDialog, AcceptAgreementDialog, ExpandCard},

    data() {
        return {
            selectedAgreement: {
                slug: null,
            },
            headers: [
                {text: 'Oferta', value: 'offer.name'},
                {text: 'Miejsca', value: 'places_number'},
                {text: 'Od', value: 'date_from'},
                {text: 'Do', value: 'date_to'},
                {text: 'Status', value: 'status'},
                {text: 'Slug', value: 'slug'},
                {text: 'Akcje', value: 'actions'},
            ],
        }
    },

    methods: {
        ...mapActions({
            fetchCompanyAgreements: 'company/fetchCompanyAgreements',
            toggleAcceptAgreementDialog: 'helpers/toggleAcceptAgreementDialog',
            toggleRejectAgreementDialog: 'helpers/toggleRejectAgreementDialog',
        }),

        formatDate(date) {
            if (date) {
                return moment(date).format('DD.MM.YYYY');
            }

            return '---';
        },

        accept(item)
        {
            this.selectedAgreement.slug = item.slug;
            this.toggleAcceptAgreementDialog(true);
        },

        reject(item)
        {
            this.selectedAgreement.slug = item.slug;
            this.toggleRejectAgreementDialog(true);
        }
    },

    computed: {
        ...mapGetters({
            company: 'company/company',
            companyLoading: 'company/companyLoading',
            companyAgreements: 'company/companyAgreements',
            companyAgreementsLoading: 'company/companyAgreementsLoading',
        }),
    },

    created() {
        this.fetchCompanyAgreements(this.$route.params.slug).then(() => {

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
