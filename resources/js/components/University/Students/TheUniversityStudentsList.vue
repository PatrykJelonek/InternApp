<template>
    <custom-card>
        <custom-confirm-dialog
            title="Akceptuj studenta"
            subheader="Czy chcesz zaakceptować studenta?"
            :confirm-function="verifyStudent"
            :confirm-function-args="[]"
            dialog-key="DIALOG_FIELD_VERIFY_STUDENT"
            :dialog-state="dialogs['DIALOG_FIELD_VERIFY_STUDENT']"
            :toggle-function="toggleDialog"
        ></custom-confirm-dialog>
        <custom-confirm-dialog
            title="Odrzuć studenta"
            subheader="Czy chcesz odrzucić studenta?"
            :confirm-function="rejectStudent"
            :confirm-function-args="[]"
            dialog-key="DIALOG_FIELD_REJECT_STUDENT"
            :dialog-state="dialogs['DIALOG_FIELD_REJECT_STUDENT']"
            :toggle-function="toggleDialog"
        >
            <validation-observer ref="observer" v-slot="{ validate }">
                <validation-provider
                    vid="reason"
                    rules="required"
                    v-slot="{ errors }"
                >
                    <v-textarea
                        outlined
                        v-model="reason"
                        label="Powód odrzucenia"
                        required
                        hide-details="auto"
                        :error-messages="errors"
                    ></v-textarea>
                </validation-provider>
            </validation-observer>
        </custom-confirm-dialog>

        <custom-card-title>
            <template v-slot:default>Lista studentów</template>
        </custom-card-title>

        <v-row v-show="show" no-gutters>
            <v-col cols="12">
                <v-data-table
                    :headers="headers"
                    :items="students"
                    :items-per-page="5"
                    :loading="studentsLoading"
                    class="component-background"
                    no-data-text="Niestety, ta uczelnia nie posiada jeszcze zarejestrowanych studentów."
                    loading-text="Pobieranie listy studentów..."
                    no-results-text="Niestety, ale nie znaleźliśmy wyników które pasowałby do podanych danych"
                    :search="search"
                >
                    <template v-slot:item.full_name="{ item }">
                        {{ item.full_name }}
                    </template>
                    <template v-slot:item.student.semester="{ item }">
                        {{ `${item.student.semester} Semestr` }}
                    </template>
                    <template v-slot:item.student.study_year="{ item }">
                        {{ `${item.student.study_year} Rok` }}
                    </template>
                    <template v-slot:item.student.specialization.name="{ item }">
                        <v-tooltip right color="tooltip-background" v-if="item.student.specialization.deleted_at">
                            <template v-slot:activator="{ on, attrs }">
                                 <span
                                     v-bind="attrs"
                                     v-on="on"
                                     :class="item.student.specialization.deleted_at ? 'text--disabled' : ''"
                                 >{{ item.student.specialization.name }}</span>
                            </template>
                            <span class="text-caption">{{
                                    `Usunięty ${formatDate(item.student.specialization.deleted_at)}`
                                }}</span>
                        </v-tooltip>
                        <template v-else>
                            {{ item.student.specialization.name }}
                        </template>
                    </template>
                    <template v-slot:item.universities_with_roles.verified="{ item }">
                        <v-chip outlined small class="ml-2" v-if="!item.universities_with_roles[0].verified">
                            Niezweryfikowany
                        </v-chip>
                        <v-chip outlined small class="ml-2" color="success" v-else>Zweryfikowany</v-chip>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-menu offset-y class="component-background">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <v-icon>mdi-dots-vertical</v-icon>
                                </v-btn>
                            </template>
                            <v-list dense color="component-background" class="cursor-pointer">
                                <v-list-item>
                                    <v-list-item-title @click="$router.push({name: 'user', params: {id: item.id}})">
                                        Zobacz profil
                                    </v-list-item-title>
                                </v-list-item>
                                <v-list-item
                                    v-if="!item.universities_with_roles[0].verified && hasUniversityRole(['deanery_worker','university_owner'])"
                                    @click="openVerifyStudentDialog(item)"
                                >
                                    <v-list-item-title>
                                        Akceptuj studenta
                                    </v-list-item-title>
                                </v-list-item>
                                <v-list-item
                                    v-if="!item.universities_with_roles[0].verified && hasUniversityRole(['deanery_worker','university_owner'])"
                                    @click="openRejectStudentDialog(item)"
                                >
                                    <v-list-item-title>
                                        Odrzuć studenta
                                    </v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import moment from "moment";
import {hasUniversityRole} from "../../../plugins/acl";
import CustomConfirmDialog from "../../_General/CustomConfirmDialog";
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";

setInteractionMode('eager');

export default {
    name: "TheUniversityStudentsList",
    components: {CustomConfirmDialog, CustomCardTitle, CustomCard, ValidationProvider, ValidationObserver},

    props: ['search'],

    data() {
        return {
            reason: null,
            show: true,
            headers: [
                {text: 'Imię i nazwisko', value: 'full_name'},
                {text: 'Indeks', value: 'student.student_index'},
                {text: 'Semestr', value: 'student.semester'},
                {text: 'Rok', value: 'student.study_year'},
                {text: 'Specjalizacja', value: 'student.specialization.name'},
                {text: 'Status', value: 'universities_with_roles.verified'},
                {text: 'Akcje', value: 'actions', sortable: false, align: 'center'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            dialogs: 'helpers/dialogs',
            dialogsArgs: 'helpers/dialogsArgs',
            university: 'university/university',
            students: 'university/students',
            studentsLoading: 'university/studentsLoading',
        }),
    },

    methods: {
        hasUniversityRole,

        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            toggleDialog: 'helpers/toggleDialog',
            setDialogArgs: 'helpers/setDialogArgs',
            fetchStudents: 'university/fetchStudents',
            verifyStudentInUniversity: 'university/verifyStudentInUniversity',
            rejectStudentInUniversity: 'university/rejectStudentInUniversity',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },

        openVerifyStudentDialog(item) {
            this.setDialogArgs({
                key: 'DIALOG_FIELD_VERIFY_STUDENT', val: {
                    userId: item.id
                }
            });
            this.toggleDialog({key: 'DIALOG_FIELD_VERIFY_STUDENT', val: true});
        },

        openRejectStudentDialog(item) {
            this.reason = null;
            this.setDialogArgs({
                key: 'DIALOG_FIELD_REJECT_STUDENT', val: {
                    userId: item.id
                }
            });
            this.toggleDialog({key: 'DIALOG_FIELD_REJECT_STUDENT', val: true});
        },

        verifyStudent() {
            this.verifyStudentInUniversity({
                slug: this.university.slug,
                userId: this.dialogsArgs['DIALOG_FIELD_VERIFY_STUDENT'].userId
            }).then(() => {
                this.setSnackbar({message: 'Student został zaakceptowany!', color: 'success'});
                this.fetchStudents(this.$route.params.slug);
            }).catch(() => {
                this.setSnackbar({message: 'Ups... Coś poszło nie tak!', color: 'error'});
            }).finally(() => {
                this.toggleDialog({key: 'DIALOG_FIELD_VERIFY_STUDENT', val: false});
                this.setDialogArgs({key: 'DIALOG_FIELD_VERIFY_STUDENT', val: null});
            });
        },

        async rejectStudent() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {
                    this.rejectStudentInUniversity({
                        slug: this.university.slug,
                        userId: this.dialogsArgs['DIALOG_FIELD_REJECT_STUDENT'].userId,
                        reason: this.reason
                    }).then(() => {
                        this.setSnackbar({message: 'Student został odrzucony!', color: 'success'});
                        this.fetchStudents(this.$route.params.slug);
                    }).catch(() => {
                        this.setSnackbar({message: 'Ups... Coś poszło nie tak!', color: 'error'});
                    }).finally(() => {
                        this.reason = null;
                        this.toggleDialog({key: 'DIALOG_FIELD_REJECT_STUDENT', val: false});
                        this.setDialogArgs({key: 'DIALOG_FIELD_REJECT_STUDENT', val: null});
                    });
                }
            })
        }
    },

    created() {
        this.fetchStudents(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
