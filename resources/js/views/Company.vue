<template>
    <v-container fluid>
       <v-row v-if="!companyLoading">
           <v-col cols="12">
               <router-view></router-view>
           </v-col>
       </v-row>
        <v-row v-else class="text-center">
            <v-col cols="12">
                <page-loader v-if="companyLoading"></page-loader>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import PageTitle from "../components/_Helpers/PageTitle";
    import PageTabHeader from "../components/_General/PageTabs";
    import PageTabs from "../components/_General/PageTabs";
    import PageLoader from "../components/_General/PageLoader";

    export default {
        name: "Company",
        components: {PageLoader, PageTabs, PageTabHeader, PageTitle, PageDetailsHeader},

        data() {
            return {
                isLoading: true,
                headers: [
                    { text: 'Nazwa', value: 'name' },
                    { text: 'Ilość miejsc', value: 'places_number' },
                    { text: 'Kategoria', value: 'offer_category.name' },
                ],
                tabs: [
                    {
                        name: 'Informacje',
                        to: {name: 'company'},
                    },
                    {
                        name: 'Oferty',
                        to: {name: 'company-offers'},
                    },
                    {
                        name: 'Umowy',
                        to: {name: 'company-agreements'},
                    },
                    {
                        name: 'Pracownicy',
                        to: {name: 'company-workers'},
                    },
                    {
                        name: 'Ustawienia',
                        to: {name: 'company-settings'},
                    },
                ],
            }
        },

        computed: {
            ...mapGetters({
                company: 'company/company',
                companyLoading: 'company/companyLoading'
            }),
        },

        methods: {
            ...mapActions({
                fetchCompany: 'company/fetchCompany'
            }),
        },

        created() {
            this.fetchCompany(this.$route.params.slug).then(() => {

            });
        }
    }
</script>

<style scoped>

</style>
