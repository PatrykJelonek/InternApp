<template>
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
                                    <validation-provider v-slot="{ errors }" vid="internshipId" rules="required">
                                        <v-select
                                            v-model="journalEntries.internshipId"
                                            :items="internships"
                                            item-text="offer.name"
                                            item-value="id"
                                            label="Nazwa praktyki"
                                            outlined
                                            hide-details="auto"
                                            dense
                                            no-data-text="Pierw musisz aplikować na praktyki!"
                                            :error-messages="errors"
                                        ></v-select>
                                    </validation-provider>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="currentDate"
                                        label="Data"
                                        disabled
                                        outlined
                                        hide-details="auto"
                                        dense
                                    ></v-text-field>
                                </v-col>
                            </v-row>
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
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import { required } from "vee-validate/dist/rules";
    import {  extend, setInteractionMode, ValidationProvider, ValidationObserver } from "vee-validate";

    setInteractionMode('eager');

    export default {
        name: "JournalFormModal",

        components: {
            ValidationProvider,
            ValidationObserver
        },

        data() {
            return {
                currentDate: '',
                dialog: false,
                journalEntries: {
                    internshipId: null,
                    content: null,
                }
            }
        },

        computed: {
            ...mapGetters({
                internships: 'user/internships',
            })
        },

        methods: {
            ...mapActions({
                fetchInternships: 'user/fetchInternships',
                fetchJournalEntries: 'user/fetchJournalEntries',
                createJournalEntries: 'journal/createJournalEntries'
            }),

            getCurrentDate() {
                let date = new Date();
                return `${String(date.getDate()).padStart(2, '0')}.${String(date.getMonth() + 1).padStart(2, '0')}.${date.getFullYear()}`;
            },

            async submit() {
                await this.createJournalEntries(this.journalEntries).then(() => {
                    this.fetchJournalEntries();
                    this.dialog = false;
                });
            }
        },

        created() {
            this.fetchInternships();
            this.currentDate = this.getCurrentDate();
        }
    };

    extend('required', {
        ...required,
        message: 'To pole jest wymagane!',
    });
</script>

<style scoped>

</style>
