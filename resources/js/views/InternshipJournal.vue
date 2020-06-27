<template>
    <v-container fluid class="ma-0 pa-0">
        <page-details-header header="Dziennik praktyk" subheader="Tu znajdziesz dziennik praktyk studenta!"></page-details-header>
        <v-container class="mt-10">
            <v-row>
                <v-col>
                    <v-btn
                        small
                        color="blue accent-4"
                        :dark="selected.length > 0"
                        :disabled="selected.length === 0"
                        @click="accept"
                    >
                        Akceptuj Wpisy
                    </v-btn>
                </v-col>
                <v-col class="d-flex justify-end">
                    <v-dialog v-model="dialog" persistent max-width="600px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                icon
                                v-bind="attrs"
                                v-on="on"
                            >
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">Nowy wpis</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <validation-observer ref="observer" v-slot="{ validate }">
                                        <v-form>
                                            <v-row>
                                                <v-col>
                                                    <validation-provider v-slot="{ errors }" vid="content" rules="required">
                                                        <v-textarea
                                                            v-model="journalEntries.content"
                                                            dense
                                                            outlined
                                                            label="Treść wpisu"
                                                            hide-details="auto"
                                                            :error-messages="errors"
                                                        ></v-textarea>
                                                    </validation-provider>
                                                </v-col>
                                            </v-row>
                                        </v-form>
                                    </validation-observer>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue accent-4" text @click="dialog = false">Anuluj</v-btn>
                                <v-btn color="blue accent-4"  dark @click="submit">Dodaj</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-card outlined>
                        <v-data-table
                            v-if="internship"
                            v-model="selected"
                            :headers="headers"
                            :items="internship.journals"
                            :items-per-page="10"
                            :loading="isLoading"
                            no-data-text="Niestety nie ma jeszcze żadnych wpisów!"
                            single-expand
                            show-expand
                            show-select
                            item-key="id"
                            sort-by="created_at"
                            sort-desc
                        >
                            <template v-slot:item.fullName="{ item }">
                                {{ item.author.first_name + ' ' + item.author.last_name }}
                            </template>
                            <template v-slot:item.created_at="{ item }">
                                {{ moment(item.created_at).format("DD.MM.YYYY HH:mm:ss") }}
                            </template>
                            <template v-slot:item.content="{ item }">
                                {{ item.content.length > 32 ? String(item.content).substr(0,32) + "..." : item.content}}
                            </template>
                            <template v-slot:item.status="{ item }">
                                <v-chip outlined :color="item.accepted == 1 ? 'success' : 'error' " dark>
                                    {{ item.accepted == 1 ? 'Zaakceptowany' : 'Niezaakceptowany'}}
                                </v-chip>
                            </template>
                            <template v-slot:expanded-item="{ headers, item }">
                                <td  class="grey lighten-4 pa-5" :colspan="headers.length">{{ item.content }}</td>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
    import moment from "moment";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import {mapActions, mapGetters} from "vuex";
    import {extend, ValidationObserver, ValidationProvider} from "vee-validate";
    import {required} from "vee-validate/dist/rules";

    export default {
        name: "StudentJournal",
        components: {PageDetailsHeader, ValidationProvider, ValidationObserver},

        data() {
            return {
                dialog: false,
                selected: [],
                isLoading: true,
                headers: [
                    {text: 'Autor', value: 'fullName'},
                    {text: 'Data', value: 'created_at'},
                    {text: 'Status', value: 'status'},
                    {text: 'Treść', value: 'content'},
                    {text: '', value: 'data-table-expand', align: 'right'},
                ],
                journalEntries: {
                    internshipId: null,
                    content: '',
                },
            }
        },

        computed: {
            ...mapGetters({
               internship: 'internship/internship',
            }),
        },

        methods: {
            ...mapActions({
                fetchInternship: 'internship/fetchInternship',
                confirmMany: 'journal/confirmMany',
                createJournalEntries: 'journal/createJournalEntries',
                confirmJournalEntries: 'journal/confirmJournalEntries',
            }),

            moment(date) {
                return moment(date);
            },

            accept() {
                this.confirmMany(this.getSelectedInternshipsId()).then(() => {
                    this.confirmJournalEntries();
                });
            },

            getSelectedInternshipsId() {
                return this.selected.map(o => o['id']);
            },

            async submit() {
                this.isLoading = true;

                await this.createJournalEntries(this.journalEntries).then(() => {
                    this.fetchInternship(this.$route.params.id).then(() => {
                        this.isLoading = false;
                    });
                    this.dialog = false;
                });
            }
        },

        created() {
            this.fetchInternship(this.$route.params.id).then(() => {
                this.journalEntries.internshipId = this.$route.params.id;
                this.isLoading = false;
            }).catch((e) => {
               this.$route.history(-1);
            });
        }
    };

    extend('required', {
        ...required,
        message: 'To pole jest wymagane!',
    });
</script>

<style scoped>

</style>
