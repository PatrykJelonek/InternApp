<template>
    <v-dialog
        v-model="dialog"
        :persistent="fileContent === null"
        :max-width="maxWidth ? maxWidth : '800px'"
        @click:outside="toggleDialog({key: 'DIALOG_FIELD_GENERATE_STUDENT_JOURNAL', val: false})"
    >
        <custom-card :loading="fileContent === null  && !error">
            <custom-card-title>
                <template v-slot:default>{{ title }}</template>
                <template v-slot:subheader>{{ subheader }}</template>
            </custom-card-title>

            <v-row no-gutters class="pa-5">
                <v-fade-transition>
                    <v-col cols="12" class="text-center text--disabled" v-if="fileContent === null && !error">
                        Generowanie pliku PDF...
                    </v-col>
                   <v-col cols="12" class="text-center error--text" v-else-if="fileContent === null && error">
                       Wystąpił problem podczas generowania dokumentu!
                   </v-col>
                    <v-col cols="12" class="text-center" v-else>
                        <v-btn
                            outlined
                            color="primary"
                            :loading="fileContent === null"
                            :href="fileContent"
                            :download="`dziennik_praktyk_studenta_${studentIndex}`"
                        >Pobierz
                        </v-btn>
                    </v-col>
                </v-fade-transition>
            </v-row>
        </custom-card>
    </v-dialog>
</template>

<script>
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";
import CustomCardFooter from "../_General/CustomCardFooter";
import {mapActions, mapGetters, mapState} from "vuex";

export default {
    name: "TheInternshipPdfGenerateDialog",
    components: {CustomCardFooter, CustomCardTitle, CustomCard},
    props: ['dialog','maxWidth', 'title', 'subheader', 'internshipId', 'studentIndex'],

    data() {
        return {
            fileContent: null,
            error: false,
        }
    },

    computed: {
        ...mapState({
            dialogsState: 'helpers/dialogs',
        }),

        ...mapGetters({
            dialogs: 'helpers/dialogs',
        })
    },

    methods: {
        ...mapActions({
            downloadInternshipJournal: 'internship/downloadInternshipJournal',
            toggleDialog: 'helpers/toggleDialog'
        }),

        async generatePdfContent() {
            await this.downloadInternshipJournal({
                internship: this.internshipId,
                student: this.studentIndex
            }).then((response) => {
                this.fileContent = `data:application/pdf;base64,${response.data}`;
            }).catch(() => {
                this.error = true;
            });
        },
    },

    watch: {
        dialog: function (newVal, oldVal) {
            if (newVal) {
                this.generatePdfContent();
            } else {
                setTimeout(() => {
                    this.fileContent = null;
                    this.error = null;
                }, 1000);
            }
        }
    }
}
</script>

<style scoped>

</style>
