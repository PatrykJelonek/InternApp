<template>
    <v-expansion-panel @change="downloadComments">
        <v-expansion-panel-header color="component-background" class="text-subtitle-1">
            Dzień {{ getInternshipDay(internshipStartDate, journalEntryDate) }}
        </v-expansion-panel-header>
        <v-expansion-panel-content
            :color="$vuetify.theme.dark ? 'component-background lighten-1' : 'component-background darken-1'"
            class="px-2">
            <v-row no-gutters class="pa-1 py-5">
                <v-col cols="12" class="mb-3">
                    <custom-card>
                        <custom-card-title>
                            <template v-slot:default>Treść wpisu</template>
                            <template v-slot:actions>
                                <v-btn-toggle dense color="transparent">
                                    <v-btn
                                        color="secondary"
                                        small
                                        outlined
                                        @click="updateJournalEntry"
                                        v-if="user.id === userId"
                                    >
                                        Edytuj
                                    </v-btn>
                                    <v-btn color="secondary" small outlined @click="deleteJournalEntry">Usuń</v-btn>
                                </v-btn-toggle>

                            </template>
                        </custom-card-title>
                        <div class="pa-5">
                            <pre class="text-body-2 text-pre-line ml-0">{{ content }}</pre>
                        </div>
                        <custom-card-footer>
                            <template v-slot:left>
                                <v-chip small outlined :color="accepted ? 'primary' : ''" pill>
                                    {{ accepted ? 'Potwierdzony' : 'Niepotwierdzony' }}
                                </v-chip>
                            </template>
                        </custom-card-footer>
                    </custom-card>
                </v-col>
                <v-col cols="12">
                    <custom-card>
                        <custom-card-title>
                            <template v-slot:default>Komentarze</template>
                            <template v-slot:actions>
                                <v-btn color="primary" small outlined @click="openCreateCommentDialog">Dodaj komentarz
                                </v-btn>
                            </template>
                        </custom-card-title>
                        <div>
                            <v-list color="transparent" class="pa-2">
                                <template v-if="!journalEntryCommentsLoading && comments.length > 0">
                                    <v-list-item
                                        v-for="(comment, index) in comments"
                                        class="rounded"
                                        :class="$vuetify.theme.dark ? 'component-background lighten-'+index%2 : 'component-background darken-'+index%2"
                                    >
                                        <v-list-item-content>
                                            <v-list-item-title>{{ comment.user.full_name }} - <span
                                                class="text-caption">{{ comment.created_at }}</span></v-list-item-title>
                                            <v-list-item-subtitle>{{ comment.content }}</v-list-item-subtitle>
                                        </v-list-item-content>
                                        <v-list-item-action
                                            v-if="comment.user.id === user.id && comment.user.email === user.email">
                                            <v-tooltip bottom>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-btn
                                                        small
                                                        color="secondary"
                                                        icon
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        @click="deleteJournalEntryComment(comment.id)"
                                                    >
                                                        <v-icon small>mdi-delete</v-icon>
                                                    </v-btn>
                                                </template>
                                                <span>Usuń komentarz</span>
                                            </v-tooltip>
                                        </v-list-item-action>
                                    </v-list-item>
                                </template>
                                <template v-else-if="journalEntryCommentsLoading">
                                    <div class="d-flex justify-center align-center">
                                        <v-progress-circular indeterminate color="primary"></v-progress-circular>
                                    </div>
                                </template>
                                <template v-else>
                                    <span
                                        class="text-center text--secondary text-body-2 pa-5 pl-4">Brak komentarzy</span>
                                </template>
                            </v-list>
                        </div>
                    </custom-card>
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
import CustomCardFooter from "../_General/CustomCardFooter";

export default {
    name: "InternshipStudentJournalEntry",
    components: {CustomCardFooter, CustomCardTitle, CustomCard, PageLoader},
    props: ['content', 'status', 'internshipStartDate', 'journalEntryDate', 'id', 'accepted', 'userId'],

    data() {
        return {
            commentsDownloaded: false,
            comments: [],
            deleted: false,
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            journalEntryComments: 'journal/journalEntryComments',
            journalEntryCommentsLoading: 'journal/journalEntryCommentsLoading',
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchJournalEntryComments: 'journal/fetchJournalEntryComments',
            toggleDialog: 'helpers/toggleDialog',
            setDialogArgs: 'helpers/setDialogArgs',
            deleteStudentJournalEntry: 'journal/deleteStudentJournalEntry',
            updateStudentJournalEntry: 'journal/updateStudentJournalEntry',
            deleteStudentJournalEntryComment: 'journal/deleteStudentJournalEntryComment',
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

        deleteJournalEntry() {
            this.setDialogArgs({key: 'DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRY', val: this.id});
            this.toggleDialog({key: 'DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRY', val: true});
        },

        deleteJournalEntryComment(commentId) {
            this.setDialogArgs({
                key: 'DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRIES_COMMENT', val: {
                    studentJournalEntryId: this.id,
                    commentId: commentId
                }
            });
            this.toggleDialog({key: 'DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_ENTRIES_COMMENT', val: true});
        },

        updateJournalEntry() {
            this.setDialogArgs({
                key: 'DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES', val: {
                    studentJournalEntryId: this.id,
                    content: this.content,
                }
            });
            this.toggleDialog({key: 'DIALOG_FIELD_CONFIRM_UPDATE_JOURNAL_ENTRIES', val: true});
        },

        openCreateCommentDialog() {
            this.toggleDialog({key: 'DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT', val: true});
            this.setDialogArgs({key: 'DIALOG_FIELD_CREATE_JOURNAL_ENTRY_COMMENT', val: this.id});
        }
    }
}
</script>

<style scoped>

</style>
