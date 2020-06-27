<template>
    <v-card outlined>
        <v-data-table
            :items="interns"
            :headers="headers"
            :items-per-page="5"
            :loading="isLoading"
            no-data-text="Ups... Nie ma żadnych praktykantów!"
        >
            <template v-slot:item.fullName="{ item }">
                {{ item.user.first_name + " " + item.user.last_name }}
            </template>
            <template v-slot:item.offerName="{ item }">
                <v-chip
                    class="ma-2"
                    color="blue accent-4"
                    outlined
                    pill
                    small
                    v-for="internship in item.internships"
                    :key="internship.id"
                    @click="$router.push({name: 'offer', params: {id: internship.offer.id}})"
                    v-if="internship.offer.company_id === selectedCompanyId"
                >
                    {{ internship.offer.name }}
                </v-chip>
            </template>
            <template v-slot:item.action="{ item }">
                <v-menu offset-y left offset-x v-model="actionsMenu" close-on-click :close-on-content-click="false">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-dots-vertical</v-icon>
                        </v-btn>
                    </template>
                    <v-list dense>
                        <v-list-group>
                            <template v-slot:activator>
                                <v-list-item-title>Dziennik Praktyk</v-list-item-title>
                            </template>
                            <v-list-item
                                v-for="internship in item.internships"
                                :key="internship.id"
                                v-if="internship.offer.company_id === selectedCompanyId"
                                :to="'/internship/'+internship.id+'/journal'"
                            >
                                <v-list-item-title>{{ internship.offer.name }}</v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                    </v-list>
                </v-menu>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "CompanyInterns",

        data() {
            return {
                actionsMenu: false,
                isLoading: true,
                headers: [
                    {text: 'Imię i nazwisko', value: 'fullName'},
                    {text: 'Nazwa oferty', value: 'offerName'},
                    {text: 'Akcje', value: 'action', align: 'right'},
                ],
            }
        },

        computed: {
            ...mapGetters({
                selectedCompanyId: 'company/selectedCompanyId',
                interns: 'company/interns'
            }),
        },

        methods: {
            ...mapActions({
                selectCompanyId: 'company/selectCompanyId',
                fetchInterns: 'company/fetchInterns',
            }),
        },

        created() {
            this.fetchInterns(this.selectedCompanyId).then(() => {
                this.isLoading = false;
            });
        }
    }
</script>

<style scoped>

</style>
