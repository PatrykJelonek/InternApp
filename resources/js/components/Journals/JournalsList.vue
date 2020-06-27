<template>
    <v-card outlined>
        <v-data-table
            :headers="headers"
            :items-per-page="10"
            :items="journalEntries"
            :loading="isLoading"
            no-data-text="Nie masz jeszcze wpisów w swoim dzienniku!"
        >
            <template v-slot:item.author="{ item }">
                {{ item.author.first_name + " " + item.author.last_name}}
            </template>
            <template v-slot:item.content="{ item }">
                {{ item.content.length > 32 ? String(item.content).substr(0,32) + "..." : item.content }}
            </template>
            <template v-slot:item.created_at="{ item }">
                {{ moment(item.created_at).format("DD.MM.YYYY HH:mm:ss") }}
            </template>
            <template v-slot:item.status="{ item }">
                <v-chip outlined :color="item.accepted == 1 ? 'success' : 'error' " dark>
                    {{ item.accepted == 1 ? 'Zaakceptowany' : 'Niezaakceptowany'}}
                </v-chip>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    import moment from "moment";
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "JournalsList",

        data() {
            return {
                isLoading: true,
                headers: [
                    {text: 'Nazwa praktyki', value: 'internship.offer.name'},
                    {text: 'Autor', value: 'author'},
                    {text: 'Treść', value: 'content'},
                    {text: 'Data dodania', value: 'created_at'},
                    {text: 'Status', value: 'status'}
                ]
            }
        },

        computed: {
            ...mapGetters({
                journalEntries: 'user/journalEntries',
            })
        },

        methods: {
            ...mapActions({
               fetchJournalEntries: 'user/fetchJournalEntries',
            }),

            moment: function (date) {
                return moment(date);
            }
        },

        created() {
            this.fetchJournalEntries().then(() => {
                this.isLoading = false;
            });
        }
    }
</script>

<style scoped>

</style>
