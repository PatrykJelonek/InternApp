<template>
    <v-dialog v-model="dialog" max-width="600">
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                icon
                v-on="on"
                v-bind="attrs"
                v-if="$route.params.studentIndex"
            >
                <v-icon>mdi-plus</v-icon>
            </v-btn>

        </template>

        <v-card>
            <v-list color="card-background">
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="text-h5">Nowe zadanie</v-list-item-title>
                        <v-list-item-subtitle>Formularz dodawania zadania do dziennika praktyk.</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <validation-observer ref="observer" v-slot="{ validate }">
                <v-form class="pa-5">
                    <v-row>
                        <v-col cols="12">
                            <validation-provider v-slot="{ errors }" vid="name" rules="required">
                                <v-text-field
                                    v-model="task.name"
                                    label="Nazwa zadania"
                                    placeholder="Szkolenie BHP..."
                                    outlined
                                    hide-details
                                    dense
                                    :error-messages="errors"
                                ></v-text-field>
                            </validation-provider>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <validation-provider v-slot="{ errors }" vid="description" rules="required">
                                <v-textarea
                                    v-model="task.description"
                                    label="Treść zadania"
                                    rows="5"
                                    dense
                                    outlined
                                    hide-details
                                    :error-messages="errors"
                                ></v-textarea>
                            </validation-provider>
                        </v-col>
                    </v-row>
                    <v-row v-has="['admin','company_supervisor','university_supervisor']">
                        <v-col cols="12">
                            <validation-provider v-slot="{ errors }" vid="done" rules="required">
                                <v-switch
                                    v-model="task.done"
                                    label="Wykonane"
                                    :ripple="false"
                                    flat
                                    inset
                                    hide-details
                                    :error-messages="errors"
                                ></v-switch>
                            </validation-provider>
                        </v-col>
                    </v-row>
                    <v-row v-has="['admin','university_worker','company_worker']">
                        <v-col cols="12">
                            <validation-provider v-slot="{ errors }" vid="students_ids" rules="required">
                                <v-select
                                    v-model="task.students_ids"
                                    :items="internshipStudents"
                                    :item-text="(item) => item.user.first_name + ' ' + item.user.last_name"
                                    item-value="id"
                                    label="Studenci"
                                    multiple
                                    outlined
                                    dense
                                    small-chips
                                    chips
                                    hint="Wybierz studentów dla których ma zostać dodany ten wpis..."
                                    persistent-hint
                                    :error-messages="errors"
                                ></v-select>
                            </validation-provider>
                        </v-col>
                    </v-row>
                </v-form>
            </validation-observer>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="primary"
                    text
                    @click="submit"
                >
                    Dodaj zadanie
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import {mapActions, mapGetters} from "vuex";

setInteractionMode('eager');

export default {
    name: "TheInternshipCreateStudentTaskDialog",

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            dialog: false,
            task: {
                name: null,
                description: null,
                internship_id: null,
                done: false,
                students_ids: []
            }
        }
    },

    computed: {
        ...mapGetters({
            currentUser: 'auth/user',
            internshipStudents: 'internship/internshipStudents',
            internship: 'internship/internship',
        })
    },

    methods: {
        ...mapActions({
            createStudentJournalEntry: 'student/createStudentJournalEntry',
            setSnackbar: 'snackbar/setSnackbar',
            addStudentJournalEntry: 'student/addStudentJournalEntry',
            createTask: 'internship/createTask'
        }),

        async submit() {
            await this.createTask({
                'internshipId': this.$route.params.internshipId,
                'studentIndex': this.$route.params.studentIndex,
                'task': this.task
            }).then((task) => {
                this.dialog = false;
                this.clearTask();
                this.setSnackbar({message: 'Zadanie zostało dodane!', color: 'success'});
            }).catch((e) => {
                this.dialog = false;
                this.setSnackbar({message: 'Nie udało się dodać zadania!', color: 'error'});
            });
        },

        clearTask() {
            this.task = {
                name: null,
                description: null,
                internship_id: null,
                done: false,
                students_ids: []
            }
        }
    }
}
</script>

<style scoped>

</style>
