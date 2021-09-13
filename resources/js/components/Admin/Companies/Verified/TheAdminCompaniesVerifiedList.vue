<template>
    <v-row>
        <v-col cols="12">
            <v-data-table
                :headers="headers"
                :items="verifiedCompanies"
                :loading="verifiedCompaniesLoading"
                :search="search"
                class="component-background"
                no-results-text="Ups... Nie udało się znaleźć szukanej firmy."
                no-data-text="Ups... Wygląda, że nie mama jeszcze żadnych firm w serwisie!"
                loading-text="Pobieranie listy firm..."
            >

            </v-data-table>
        </v-col>
    </v-row>
</template>

<script>
import CustomCard from "../../../_General/CustomCard";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "TheAdminCompaniesVerifiedList",
    components: {CustomCard},
    data() {
        return {
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Typ', value: 'type.name'},
                {text: 'Adres', value: 'full_address'},
                {text: 'Email', value: 'email'},
                {text: 'Akcje', value: 'actions'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            verifiedCompanies: 'company/verifiedCompanies',
            verifiedCompaniesLoading: 'company/verifiedCompaniesLoading',
        }),
    },

    methods: {
        ...mapActions({
           fetchVerifiedCompanies: 'company/fetchVerifiedCompanies'
        }),
    },

    created() {
        this.fetchVerifiedCompanies().then(() => {

        }).catch(() => {

        });
    }
}
</script>

<style scoped>

</style>
