<template>
    <expand-card
        title="Aplikacje na praktyki"
        description="Oto lista twoich aplikacji na praktyki."
    >
        <v-data-table
            :headers="headers"
            :items="internships"
            :items-per-page="5"
            :loading="internshipsLoading"
            class="elevation-1 card-background"
        >
            <template v-slot:item.status="{ item }">
                <v-chip label outlined small color="primary">{{ getStatusDisplayName(item.status.name) }}</v-chip>
            </template>
            <template v-slot:item.created="{ item }">
                {{ formatDate(item.created_at) }}
            </template>
        </v-data-table>
    </expand-card>
</template>

<script>
import moment from "moment";
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../../_Helpers/ExpandCard";

export default {
    name: "TheStudentOfferApplicationsList",
    components: {ExpandCard},
    data() {
        return {
            show: true,
            emptyInternshipsListMessage: 'Ładowanie listy praktyk...',
            headers: [
                {text: 'Nazwa', value: 'offer.name'},
                {text: 'Status', value: 'status'},
                {text: 'Data Aplikacji', value: 'created'},
            ]
        }
    },

    computed: {
        ...mapGetters({
            internships: 'user/newInternships',
            internshipsLoading: 'user/newInternshipsLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchInternships: 'user/fetchNewInternships',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },

        getStatusDisplayName(status) {
            switch (status) {
                case 'new':
                    return 'Nowy';
                    break;
                case 'accepted':
                    return 'Zaakceptowany';
                    break;
                default:
                    return status;
                    break;
            }
        },
    },

    created() {
        this.fetchInternships().then(() => {
            this.emptyInternshipsListMessage = 'Aktualnie nie posiadasz żadnych praktyk.'
        }).catch((e) => {
            this.emptyInternshipsListMessage = 'Wystąpił błąd podczas pobierania listy aplikacji na praktyki.'
        });
    }
}
</script>

<style scoped>

</style>
