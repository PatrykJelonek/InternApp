<template>
    <v-dialog
        v-model="dialogs['DIALOG_FIELD_INTERNSHIP_SUMMARY']"
        class="component-background"
        persistent
        max-width="800"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Zakończ praktykę</template>
                <template v-slot:subheader>Wystaw opinię praktykantom</template>
                <template v-slot:actions>
                    <v-btn icon @click="toggleDialog({key: 'DIALOG_FIELD_INTERNSHIP_SUMMARY', val: false})">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>
            <validation-observer ref="observer" v-slot="{ validate }">
                <v-form>
                    <v-virtual-scroll
                        :items="internshipStudents"
                        height="525"
                        item-height="260"
                        v-if="opinions.length > 0"
                    >
                        <template v-slot:default="{ index, item }">
                            <v-row no-gutters class="pa-5">
                                <v-col cols="12">
                                    <v-text-field
                                        label="Imię i nazwisko"
                                        dense
                                        outlined
                                        disabled
                                        :value="item.user.full_name + ' - ' + item.student_index"
                                        hide-details
                                        class="mb-3"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-input hide-details disabled hidden v-model="opinions[index].index"
                                             :value="item.student_index"></v-input>
                                </v-col>
                                <v-col cols="12">
                                    <validation-provider
                                        :vid="`opinion_${internshipId}_${item.student_index}`"
                                        v-slot="{ errors }"
                                        rules="required"
                                    >
                                        <v-textarea
                                            v-model="opinions[index].opinion"
                                            label="Opinia o studencie"
                                            dense
                                            outlined
                                            :error-messages="errors"
                                            hide-details="auto"
                                        ></v-textarea>
                                    </validation-provider>
                                </v-col>
                                <v-col cols="12" class="my-5" v-if="index !== internshipStudents.length - 1">
                                    <v-divider></v-divider>
                                </v-col>
                            </v-row>
                        </template>
                    </v-virtual-scroll>

                    <custom-card-footer>
                        <template v-slot:right>
                            <v-btn outlined color="primary" @click="summarize">
                                Zapisz
                            </v-btn>
                        </template>
                    </custom-card-footer>
                </v-form>
            </validation-observer>
        </custom-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";
import CustomCardFooter from "../_General/CustomCardFooter";
import {ValidationObserver, ValidationProvider} from "vee-validate";

export default {
    name: "InternshipSummaryDialog",
    components: {
        CustomCardFooter,
        CustomCardTitle,
        CustomCard,
        ValidationProvider,
        ValidationObserver
    },

    props: ['internshipStudents', 'internshipId'],

    data() {
        return {
            opinions: []
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
            setSnackbar: 'snackbar/setSnackbar',
            toggleDialog: 'helpers/toggleDialog',
            summarizeInternship: 'internship/summarizeInternship',
        }),

        async summarize() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {
                    this.summarizeInternship({
                        internship: this.internshipId,
                        opinions: this.opinions
                    }).then((response) => {
                        this.setSnackbar({message: 'Praktyka została zakończona', color: 'success'});
                        this.toggleDialog({key: 'DIALOG_FIELD_INTERNSHIP_SUMMARY', val: false});
                    }).catch((e) => {
                        if (e.response !== undefined && e.response.status === 422) {
                            this.$refs.observer.setErrors(e.response.data.errors);
                        } else {
                            this.setSnackbar({message: 'Nie udało się zakończyć praktyki', color: 'success'});
                            this.toggleDialog({key: 'DIALOG_FIELD_INTERNSHIP_SUMMARY', val: false});
                        }
                    });
                }
            });
        }
    },

    created() {
        this.internshipStudents.forEach((student) => {
            this.opinions.push({
                index: student.student_index,
                opinion: '',
            })
        });
    }
}
</script>

<style scoped>

</style>
