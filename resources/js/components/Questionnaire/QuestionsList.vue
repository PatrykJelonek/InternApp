<template>
    <v-row no-gutters>
        <v-col cols="12">
            <h2>{{ questionnaireName }}</h2>
            <p>{{ questionnaireDescription }}</p>
        </v-col>
        <v-col cols="12">
            <v-form>
                <validation-observer ref="observer" v-slot="{ validate }">
                    <v-row no-gutters>
                        <v-col cols="12">
                            <expand-card
                                v-for="(question, index) in questionnaireQuestions"
                                :key="question.id"
                                :description="'Pytanie nr ' + (index + 1)"
                                :title="question.content"
                                class="mt-5"
                            >
                                <v-row>
                                    <v-col cols="12" class="pa-10">
                                        <validation-provider v-slot="{ errors }" :vid="'answer' + index"
                                                             rules="required">
                                            <v-textarea
                                                v-model="answers[index].content"
                                                outlined
                                                hide-details="auto"
                                                :error-messages="errors"
                                                :label="'Odpowiedź nr ' + (index + 1)"
                                            ></v-textarea>
                                        </validation-provider>
                                    </v-col>
                                </v-row>
                            </expand-card>
                        </v-col>
                        <v-col cols="12" class="pt-5">
                            <custom-card class="pa-5">
                                <v-row class="d-flex align-center">
                                    <v-col cols="12" md="6"
                                           v-bind:class="$vuetify.breakpoint.mdAndDown ? 'text-center' : 'text-left'">
                                        Dziękujemy za wypełnienie ankiety, teraz możesz wysłać swoje odpowiedzi.
                                    </v-col>
                                    <v-col cols="12" md="6"
                                           v-bind:class="$vuetify.breakpoint.mdAndDown ? 'text-center' : 'text-right'">
                                        <v-btn outlined color="primary" @click="sendAnswers">Wyślij odpowiedzi</v-btn>
                                    </v-col>
                                </v-row>
                            </custom-card>
                        </v-col>
                    </v-row>
                </validation-observer>
            </v-form>
        </v-col>
    </v-row>
</template>

<script>
import ExpandCard from "../_Helpers/ExpandCard";
import CustomCard from "../_General/CustomCard";
import {extend, setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import {mapActions, mapGetters} from "vuex";

setInteractionMode('eager');

export default {
    name: "QuestionsList",
    components: {
        CustomCard,
        ExpandCard,
        ValidationProvider,
        ValidationObserver
    },
    props: ['questionnaireName', 'questionnaireDescription', 'questionnaireId'],

    data() {
        return {
            answers: []
        }
    },

    computed: {
        ...mapGetters({
            questionnaireQuestions: 'questionnaire/questionnaireQuestions'
        }),
    },

    methods: {
        ...mapActions({
            fetchQuestionnaireQuestions: 'questionnaire/fetchQuestionnaireQuestions',
            addQuestionnaireAnswers: 'questionnaire/addQuestionnaireAnswers',
            setSnackbar: 'snackbar/setSnackbar'
        }),

        async sendAnswers() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {
                    this.addQuestionnaireAnswers({
                        id: this.questionnaireId,
                        answers: this.answers
                    }).then((response) => {
                        this.setSnackbar({message: 'Odpowiedzi zostały zapisane!', color: 'success'});
                    }).catch((e) => {
                        console.log(e.response);
                        if (e.response.status === 422) {
                            this.$refs.observer.setErrors(e.response.data.errors);
                        } else {
                            this.setSnackbar({message: 'Nie udało się zapisać odpowiedzi!', color: 'error'});
                        }
                    });
                }
            }).catch((e) => {

            });
        }
    },

    created() {
        this.fetchQuestionnaireQuestions((this.questionnaireId)).then((response) => {
            this.questionnaireQuestions.forEach((question) => {
                this.answers.push({
                    questionnaireQuestionId: question.id,
                    content: null,
                });
            });
            this.answers.filter((answer) => {
                return answer !== undefined;
            })
        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
