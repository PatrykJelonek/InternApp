<template>
    <v-dialog
        v-model="dialogs['DIALOG_FIELD_RATE_STUDENT']"
        class="component-background"
        @click:outside="close"
        persistent
        max-width="600"
        v-if="dialogsArgs['DIALOG_FIELD_RATE_STUDENT'].student !== null"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Wystaw ocenę</template>
                <template v-slot:subheader>Oceń praktykę/staż studenta</template>
                <template v-slot:actions>
                    <v-btn icon @click="close">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>
            <validation-observer ref="observer" v-slot="{ validate }">
                <v-form>
                    <v-row no-gutters class="pa-5">
                        <v-col cols="12">
                            <validation-provider
                                vid="index"
                                v-slot="{ errors }"
                            >
                                <v-text-field
                                    label="Student"
                                    outlined
                                    :value="`${student.user.full_name} - ${student.student_index}`"
                                    dense
                                    readonly
                                    disabled
                                    :error-messages="errors"
                                ></v-text-field>
                            </validation-provider>
                        </v-col>
                        <v-col cols="12">
                            <validation-provider
                                vid="grade"
                                v-slot="{ errors }"
                                rules="required|oneOf:2,2.5,3,3.5,4,4.5,5"
                            >
                                <v-select
                                    v-model="selectedGrade"
                                    label="Ocena studenta"
                                    :items="grades"
                                    item-value="grade"
                                    :item-text="(item) => `${item.grade} - ${item.text}`"
                                    outlined
                                    dense
                                    :error-messages="errors"
                                    hide-details="auto"
                                ></v-select>
                            </validation-provider>
                        </v-col>
                    </v-row>
                </v-form>
            </validation-observer>

            <custom-card-footer>
                <template v-slot:right>
                    <v-btn outlined color="primary" @click="submit">Zapisz</v-btn>
                </template>
            </custom-card-footer>
        </custom-card>
    </v-dialog>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";
import CustomCardFooter from "../_General/CustomCardFooter";
import {extend, ValidationObserver, ValidationProvider} from "vee-validate";
import {oneOf} from 'vee-validate/dist/rules';

extend('oneOf', oneOf);

export default {
    name: "InternshipRateStudentDialog",
    components: {
        CustomCardFooter,
        CustomCardTitle,
        CustomCard,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            grades: [
                {grade: 2, text: 'Dopuszczający'},
                {grade: 2.5, text: 'Dopuszczający plus'},
                {grade: 3, text: 'Dostateczny'},
                {grade: 3.5, text: 'Dostateczny plus'},
                {grade: 4, text: 'Dobry'},
                {grade: 4.5, text: 'Dobry plus'},
                {grade: 5, text: 'Bardzo dobry'},
            ],
            selectedGrade: null,
        }
    },

    computed: {
        ...mapGetters({
            dialogs: 'helpers/dialogs',
            dialogsArgs: 'helpers/dialogsArgs',
            student: 'student/student'
        })
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleDialog'
        }),

        async submit() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {

                }
            });
        },

        close() {
            this.selectedGrade = null;
            this.toggleDialog({key: 'DIALOG_FIELD_RATE_STUDENT', val: false});
        }
    }
}
</script>

<style scoped>

</style>
