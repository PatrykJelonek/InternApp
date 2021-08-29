<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Aplikacje na praktyki</template>
            <template v-slot:subheader>Oto lista twoich aplikacji na praktyki.</template>
        </custom-card-title>

        <v-data-table
            :headers="headers"
            :items="internships"
            :items-per-page="5"
            :loading="internshipsLoading"
            class="card-background"
            no-data-text="Brak aplikacji na praktyki!"
        >
            <template v-slot:item.status.display_name="{ item }">
                <v-chip outlined small :color="item.status.hex_color">{{ item.status.display_name }}</v-chip>
            </template>
            <template v-slot:item.created="{ item }">
                {{ formatDate(item.created_at) }}
            </template>
            <template v-slot:item.agreement.university.name="{ item }">
                <router-link :to="{name: 'university', params: {slug: item.agreement.university.slug}}">{{ item.agreement.university.name }}</router-link>
            </template>
            <template v-slot:item.agreement.company.draft_name="{ item }">
                <router-link :to="{name: 'company', params: {slug: item.agreement.company.slug}}">{{ item.agreement.company.draft_name }}</router-link>
            </template>
        </v-data-table>
    </custom-card>
</template>

<script>
import moment from "moment";
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheStudentOfferApplicationsList",
    components: {CustomCardTitle, CustomCard, ExpandCard},
    data() {
        return {
            show: true,
            emptyInternshipsListMessage: 'Ładowanie listy praktyk...',
            headers: [
                {text: 'Nazwa', value: 'agreement.name'},
                {text: 'Uczelnia', value: 'agreement.university.name'},
                {text: 'Firma', value: 'agreement.company.draft_name'},
                {text: 'Data Aplikacji', value: 'created'},
                {text: 'Status', value: 'status.display_name'},
            ]
        }
    },

    computed: {
        ...mapGetters({
            internships: 'user/internships',
            internshipsLoading: 'user/internshipsLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchInternships: 'user/fetchInternships',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },
    },

    created() {
        this.fetchInternships().then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
