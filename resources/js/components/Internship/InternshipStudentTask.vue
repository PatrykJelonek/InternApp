<template>
    <v-expansion-panel>
        <v-expansion-panel-header color="component-background" class="text-subtitle-1 px-5 py-2">
            <v-row no-gutters>
                <v-col cols="12">
                    {{ name }}
                </v-col>
                <v-col cols="12">
                    <span class="text--disabled text-body-2">{{ description.substr(0, 40) }}...</span>
                </v-col>
            </v-row>
        </v-expansion-panel-header>
        <v-expansion-panel-content
            :color="$vuetify.theme.dark ? 'component-background lighten-1' : 'component-background darken-1'"
            class="px-2"
        >
            <v-row no-gutters class="pa-1 py-5">
                <v-col cols="12">
                    <custom-card>
                        <custom-card-title>
                            <template v-slot:default>Treść zadania</template>
                            <template v-slot:actions>
                                <v-btn-toggle background-color="transparent" borderless>
                                    <v-btn
                                        color="secondary"
                                        small
                                        outlined
                                        @click="deleteTask"
                                    >
                                        Usuń
                                    </v-btn>
                                </v-btn-toggle>
                            </template>
                        </custom-card-title>
                        <v-row no-gutters>
                            <v-col cols="12" class="pa-5">
                                {{ description }}
                            </v-col>
                        </v-row>
                        <custom-card-footer>
                            <template v-slot:left>
                                <v-chip small outlined :color="done ? 'primary' : ''" pill>
                                    {{ done ? 'Zadanie wykonane' : 'Zadanie niewykonane' }}
                                </v-chip>
                            </template>
                            <template v-slot:right>
                                <v-btn-toggle borderless background-color="transparent">
                                    <v-btn
                                        color="secondary"
                                        small
                                        outlined
                                        @click="acceptTask"
                                        v-if="!done && userId === user.id"
                                    >
                                        Oznacz jako wykonane
                                    </v-btn>
                                </v-btn-toggle>
                            </template>
                        </custom-card-footer>
                    </custom-card>
                </v-col>
            </v-row>
        </v-expansion-panel-content>
    </v-expansion-panel>
</template>

<script>
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";
import CustomCardFooter from "../_General/CustomCardFooter";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "InternshipStudentTask",
    components: {CustomCardFooter, CustomCardTitle, CustomCard},
    props: ['name', 'description', 'done', 'userId', 'id', 'internshipId', 'studentIndex'],

    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
    },

    methods: {
        ...mapActions({
            toggleDialogs: 'helpers/toggleDialog',
            setDialogArgs: 'helpers/setDialogArgs',
            acceptStudentTask: 'task/acceptStudentTask',
            setSnackbar: 'snackbar/setSnackbar',
            fetchStudentTasks: 'student/fetchStudentTasks',
        }),

        deleteTask() {
            this.setDialogArgs({key: 'DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_TASK', val: this.id});
            this.toggleDialogs({key: 'DIALOG_FIELD_CONFIRM_DELETE_JOURNAL_TASK', val: true});
        },

        acceptTask() {
            this.acceptStudentTask({
                internshipId: this.internshipId,
                studentIndex: this.studentIndex,
                taskId: this.id
            }).then(() => {
                this.setSnackbar({message: 'Zadanie zostało oznaczone jako wykonane!', color: 'success'})
                this.done = true;
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się oznaczyć zadania jako wykonane!', color: 'error'})
            });
        }
    }
}
</script>

<style scoped>

</style>
