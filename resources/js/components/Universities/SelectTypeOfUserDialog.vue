<template>
    <v-dialog
        v-model="dialogs['DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER']"
        width="600px"
        @click:outside="close"
        persistent
        class="component-background"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Wybierz typ</template>
                <template v-slot:subheader>Wybierz czy jesteś pracownikiem czy studentem.</template>
                <template v-slot:actions>
                    <v-btn icon @click="close">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>

            <v-row no-gutters class="pa-5">
                <v-col cols="5">
                    <v-card ripple outlined :color="isSelected.worker ? 'primary' : 'component-background lighten-1'"
                            class="text--primary d-flex justify-center align-center flex-column py-5"
                            @click="isSelected.worker = !isSelected.worker; isSelected.student = false">
                        <v-card-title>
                            <v-icon>mdi-account-tie</v-icon>
                        </v-card-title>
                        <v-card-subtitle>Pracownik</v-card-subtitle>
                    </v-card>
                </v-col>
                <v-col cols="5" offset="2">
                    <v-card ripple outlined :color="isSelected.student ? 'primary' : 'component-background lighten-1'"
                            class="d-flex justify-center align-center flex-column py-5"
                            @click="isSelected.student = !isSelected.student; isSelected.worker = false">
                        <v-card-title>
                            <v-icon>mdi-card-account-details-outline</v-icon>
                        </v-card-title>
                        <v-card-subtitle>Student</v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>

            <v-expand-transition>
                <template v-if="isSelected.student">
                    <div>
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-divider></v-divider>
                            </v-col>
                        </v-row>
                        <v-row no-gutters class="pa-5">
                            <v-col cols="12">

                            </v-col>
                            <v-col cols="12">
                                <v-form>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="student.index"
                                                outlined
                                                dense
                                                label="Indeks studenta"
                                                hide-details="auto"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="student.semester"
                                                outlined
                                                dense
                                                label="Semestr"
                                                hide-details="auto"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-select
                                                v-model="student.faculty"
                                                @change="student.field = null; student.specialization = null;"
                                                :items="dialogsArgs['DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER'].faculties"
                                                item-text="name"
                                                return-object
                                                outlined
                                                dense
                                                label="Wydział"
                                                hide-details="auto"
                                            ></v-select>
                                        </v-col>
                                        <v-expand-transition>
                                            <v-col cols="12">
                                                <v-select
                                                    v-if="student.faculty"
                                                    v-model="student.field"
                                                    :items="student.faculty.fields"
                                                    item-text="name"
                                                    return-object
                                                    outlined
                                                    dense
                                                    label="Kierunek"
                                                    hide-details="auto"
                                                ></v-select>
                                            </v-col>
                                        </v-expand-transition>
                                        <v-expand-transition>
                                            <v-col cols="12">
                                                <v-select
                                                    v-if="student.field"
                                                    v-model="student.specialization"
                                                    :items="student.field.specializations"
                                                    item-text="name"
                                                    return-object
                                                    outlined
                                                    dense
                                                    label="Specjalność"
                                                    hide-details="auto"
                                                ></v-select>
                                            </v-col>
                                        </v-expand-transition>
                                    </v-row>
                                </v-form>
                            </v-col>
                        </v-row>
                    </div>
                </template>
            </v-expand-transition>

            <custom-card-footer>
                <template v-slot:right>
                    <v-btn color="primary" outlined :disabled="!isSelected.worker && !isSelected.student" @click="join">
                        Dołącz
                    </v-btn>
                </template>
            </custom-card-footer>
        </custom-card>
    </v-dialog>
</template>

<script>
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";
import CustomCardFooter from "../_General/CustomCardFooter";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "SelectTypeOfUserDialog",
    components: {CustomCardFooter, CustomCardTitle, CustomCard},

    data() {
        return {
            type: null,
            isSelected: {
                worker: false,
                student: false,
            },
            student: {
                index: null,
                semester: null,
                year: null,
                faculty: null,
                field: null,
                specialization: null,
            }
        }
    },

    computed: {
        ...mapGetters({
            dialogs: 'helpers/dialogs',
            dialogsArgs: 'helpers/dialogsArgs',
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog',
            setSnackbar: 'snackbar/setSnackbar',
            addWorkerToUniversity: 'university/addWorkerToUniversity',
            addStudentToUniversity: 'university/addStudentToUniversity',
            fetchUserUniversities: 'user/fetchUserUniversities'
        }),

        close() {
            this.toggleDialog({key: 'DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER', val: false});
        },

        async join() {
            if (this.isSelected.worker) {
                await this.addWorkerToUniversity({
                    slug: this.dialogsArgs['DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER'].slug,
                    userId: this.dialogsArgs['DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER'].userId
                }).then((response) => {
                    this.fetchUserUniversities();
                    this.close();
                    this.setSnackbar({message: 'Zostałeś dodany do uczelni!', color: 'success'});
                }).catch((e) => {
                    this.close();
                    this.setSnackbar({message: 'Wystąpił problem, skontaktuj się administratorem!', color: 'error'});
                });
            }

            if (this.isSelected.student) {
                await this.addStudentToUniversity({
                    slug: this.dialogsArgs['DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER'].slug,
                    userId: this.dialogsArgs['DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER'].userId,
                    student: this.student,
                }).then((response) => {
                    // this.fetchUserUniversities();
                    // this.close();
                    // this.setSnackbar({message: 'Zostałeś dodany do uczelni!', color: 'success'});
                }).catch((e) => {
                    // this.close();
                    // this.setSnackbar({message: 'Wystąpił problem, skontaktuj się administratorem!', color: 'error'});
                });
            }
        }
    }
}
</script>

<style scoped>

</style>
