<template>
    <v-expansion-panel @change="downloadComments">
        <v-expansion-panel-header color="component-background" class="text-subtitle-1">
            Dzień {{ getInternshipDay(internshipStartDate, journalEntryDate) }}
        </v-expansion-panel-header>
        <v-expansion-panel-content
            color="background"
        >
            <v-row no-gutters class="pa-1 py-5">
                <v-col cols="12" class="mb-3">
                    <custom-card>
                        <custom-card-title>
                            <template v-slot:default>Treść wpisu</template>
                            <template v-slot:actions>
                                <v-btn color="primary" small outlined @click="openCreateCommentDialog">Edytuj</v-btn>
                            </template>
                        </custom-card-title>
                        <div class="pa-5">
                            <pre class="text-body-2 text-pre-line ml-0">
                        {{ content }}
                    </pre>
                        </div>
                    </custom-card>
                </v-col>
<!--                <v-col cols="12" class="mb-2 mt-5">-->
<!--                    <h3 class="text-body-2">Komentarze: </h3>-->
<!--                </v-col>-->
                <v-col cols="12">
                    <custom-card>
                        <custom-card-title>
                            <template v-slot:default>Komentarze</template>
                            <template v-slot:actions>
                                <v-btn color="primary" small outlined @click="openCreateCommentDialog">Dodaj komentarz</v-btn>
                            </template>
                        </custom-card-title>
                        <div class="pa-2">
                            <v-list color="transparent">
                                <template v-if="!journalEntryCommentsLoading && comments.length > 0">
                                    <v-list-item
                                        v-for="(comment, index) in comments"
                                        class="rounded"
                                        :class="$vuetify.theme.dark ? 'component-background lighten-'+index%2 : 'component-background darken-'+index%2"
                                    >
                                        <v-list-item-content>
                                            <v-list-item-title>{{comment.user.full_name}} - <span class="text-caption">{{ comment.created_at }}</span></v-list-item-title>
                                            <v-list-item-subtitle>{{comment.content}}</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                </template>
                                <template v-else-if="journalEntryCommentsLoading">
                                    <div class="d-flex justify-center align-center">
                                        <v-progress-circular indeterminate color="primary"></v-progress-circular>
                                    </div>
                                </template>
                                <template v-else>
                                    <span class="text-center text--secondary text-body-2">Brak komentarzy</span>
                                </template>
                            </v-list>
                        </div>
                    </custom-card>
                </v-col>
                <v-col cols="12" class="d-flex justify-center align-center mt-3">

                </v-col>
            </v-row>
        </v-expansion-panel-content>
    </v-expansion-panel>
</template>

<script>
import moment from "moment";
import {mapActions, mapGetters} from "vuex";
import PageLoader from "../_General/PageLoader";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";

export default {
    name: "InternshipStudentJournalEntry",
    components: {CustomCardTitle, CustomCard, PageLoader},
    props: ['content', 'status', 'internshipStartDate', 'journalEntryDate', 'id'],

    data() {
        return {
            commentsDownloaded: false,
            comments: [],
        }
    },

    computed: {
        ...mapGetters({
            journalEntryComments: 'journal/journalEntryComments',
            journalEntryCommentsLoading: 'journal/journalEntryCommentsLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchJournalEntryComments: 'journal/fetchJournalEntryComments',
            toggleDialog: 'helpers/toggleDialog',
            setDialogArgs: 'helpers/setDialogArgs'
        }),

        getInternshipDay: (internshipStartDate, journalEntryDate) => {
            return moment(journalEntryDate).diff(moment(internshipStartDate), 'days') + 1;
        },

        downloadComments() {
            this.fetchJournalEntryComments({
                    internshipId: this.$route.params.internshipId,
                    studentIndex: this.$route.params.studentIndex,
                    studentJournalEntryId: this.id
                }
            ).then(() => {
                this.comments = JSON.parse(JSON.stringify(this.journalEntryComments));
            })
        },

        openCreateCommentDialog()
        {
            this.toggleDialog({key: 'DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT', val: true});
            this.setDialogArgs({key: 'DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT', val: this.id});
        }
    }
}
</script>

<style scoped>

</style>
