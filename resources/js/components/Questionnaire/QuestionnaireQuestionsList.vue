<template>
    <v-card color="transparent" flat>
        <v-row no-gutters>
            <v-col cols="12">
                <validation-observer ref="observer" v-slot="{ validate }">
                    <template v-if="questions.length > 0">
                        <v-row v-for="(item, index) in questions" :key="item.id">
                            <v-col cols="12">
                                <validation-provider v-slot="{ errors }" :vid="'content'+index" rules="required">
                                    <v-text-field
                                        v-model="questions[index].content"
                                        :label="'Pytanie nr '+ (index+1)"
                                        dense
                                        outlined
                                        :value="item.content"
                                        hide-details="auto"
                                        :error-messages="errors"
                                        class="d-flex align-center"
                                        @change="checkQuestionWasModified"
                                        :readonly="item.deleted_at !== null && item.deleted_at !== undefined"
                                    >
                                        <template v-slot:prepend>
                                            <v-btn-toggle dense background-color="transparent">
                                                <v-btn icon @click="goUp(item.position, index)"
                                                       :disabled="questions[index-1]=== undefined">
                                                    <v-icon>mdi-chevron-up</v-icon>
                                                </v-btn>
                                                <v-btn icon @click="goDown(item.position, index)"
                                                       :disabled="questions[index+1] === undefined">
                                                    <v-icon>mdi-chevron-down</v-icon>
                                                </v-btn>
                                            </v-btn-toggle>
                                        </template>
                                        <template v-slot:append-outer>
                                            <v-icon @click="deleteElement(item, index)">
                                                {{
                                                    item.deleted_at !== null && item.deleted_at !== undefined ? 'mdi-delete-off-outline' : 'mdi-delete-outline'
                                                }}
                                            </v-icon>
                                        </template>
                                    </v-text-field>
                                </validation-provider>
                            </v-col>
                        </v-row>
                    </template>
                    <template v-else>
                        <v-row>
                            <v-col cols="12" class="text-center">
                                <p class="subtitle-2 text--disabled">Ta ankieta nie posiada jeszcze pytań!</p>
                            </v-col>
                        </v-row>
                    </template>
                </validation-observer>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <v-btn-toggle dense background-color="transparent">
                            <v-btn
                                outlined
                                @click="addQuestionInput"
                                @change="checkQuestionWasModified"
                            >
                                <v-icon dense class="mr-2">mdi-plus</v-icon>
                                Dodaj
                            </v-btn>
                            <v-btn
                                outlined
                                @click="modifyQuestions"
                                :disabled="!wasQuestionsModified"
                            >
                                Zapisz
                                <v-icon dense class="ml-2">mdi-content-save-outline</v-icon>
                            </v-btn>
                        </v-btn-toggle>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import {isEqual} from "lodash";
import CustomCard from "../_General/CustomCard";
import ExpandCard from "../_Helpers/ExpandCard";
import VCardHeader from "../_Helpers/VCardHeader";
import {mapActions, mapGetters} from "vuex";
import {extend, setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";

setInteractionMode('eager');


export default {
    name: "QuestionnaireQuestionsList",
    components: {VCardHeader, ExpandCard, CustomCard, ValidationProvider, ValidationObserver},
    props: ['originalQuestions', 'questionnaireId'],

    data() {
        return {
            nameToSave: null,
            descriptionToSave: null,
            questions: [],
            expand: false,
            wasQuestionsModified: false,
        }
    },

    computed: {
        ...mapGetters({
            questionnaire: 'questionnaire/questionnaire',
            questionnaires: 'questionnaire/questionnaires',
            questionnaireQuestions: 'questionnaire/questionnaireQuestions',
        })
    },

    methods: {
        ...mapActions({
            modifyQuestionnaireQuestions: 'questionnaire/modifyQuestionnaireQuestions',
            setQuestionnaireQuestions: 'questionnaire/setQuestionnaireQuestions',
            setSnackbar: 'snackbar/setSnackbar',
        }),

        addQuestionInput() {
            let {lastId, lastPosition} = this.getLastQuestionData(this.questions);
            this.questions.push({
                id: lastId + 1,
                questionnaire_id: this.questionnaireId,
                content: '',
                description: null,
                position: lastPosition + 1,
                created_at: null,
                deleted_at: null,
            });
            this.questions = this.sortQuestionsByPosition(this.questions);
            this.checkQuestionWasModified();
        },

        goUp(pos, key) {
            [this.questions[key].position, this.questions[key - 1].position] = [this.questions[key - 1].position, this.questions[key].position];
            this.questions = this.sortQuestionsByPosition(this.questions);
            this.checkQuestionWasModified();
        },

        goDown(pos, key) {
            [this.questions[key].position, this.questions[key + 1].position] = [this.questions[key + 1].position, this.questions[key].position];
            this.questions = this.sortQuestionsByPosition(this.questions);
            this.checkQuestionWasModified();
        },

        sortQuestionsByPosition(questions) {
            let tmpQuestions = [...questions];

            tmpQuestions.sort((a, b) => {
                if (a.position > b.position) {
                    return 1;
                }

                if (a.position < b.position) {
                    return -1;
                }

                return 0;
            })

            return tmpQuestions;
        },

        getLastQuestionData(questions) {
            let lastId = questions[0] ? questions[0].id : 0;
            let lastPosition = questions[0] ? questions[0].position : 1;

            questions.forEach((question) => {
                lastId = question.id > lastId ? question.id : lastId;
                lastPosition = question.position > lastPosition ? question.position : lastPosition;
            });

            return {lastId, lastPosition};
        },

        checkQuestionWasModified() {
            this.wasQuestionsModified = !isEqual(this.sortQuestionsByPosition(this.questions), this.sortQuestionsByPosition(JSON.parse(JSON.stringify(this.originalQuestions))));
        },

        getQuestionOriginalPosition(question) {
            this.originalQuestions.forEach((originalQuestion) => {
                if (question.id === originalQuestion.id) {
                    return originalQuestion.position;
                }
            });

            return question.position;
        },

        deleteElement(item, index) {
            if (item.created_at !== null) {
                item.deleted_at = item.deleted_at === null ? this.getDate() : null;
            } else {
                if (this.questions[index + 1] !== undefined) {
                    this.questions[index + 1].position = this.getQuestionOriginalPosition(this.questions[index + 1]);
                }
                this.questions.splice(index, 1);
            }

            this.questions = this.sortQuestionsByPosition(this.questions);
            this.checkQuestionWasModified();
        },

        getDate() {
            return this.moment().format();
        },

        normalizePosition() {
            let position = 1;
            this.questions.forEach((question) => {
                question.position = position++;
            })
        },

        async modifyQuestions() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {
                    this.normalizePosition();
                    this.modifyQuestionnaireQuestions({
                        id: this.questionnaireId,
                        questions: this.questions
                    }).then((response) => {
                        this.setSnackbar({message: 'Pytania zostały zapisane!', color: 'success'});
                        this.setQuestionnaireQuestions({id: this.questionnaireId, questions: response.data});
                        this.questions = JSON.parse(JSON.stringify(this.questionnaire.questions));
                    }).catch((e) => {
                        console.log(e);
                        this.setSnackbar({message: 'Nie udało się zapisać pytań!', color: 'error'});
                    });
                }
            });
        },
    },

    created() {
        this.questions = JSON.parse(JSON.stringify(this.originalQuestions));
        this.questions = this.sortQuestionsByPosition(this.questions);
    }
}
</script>

<style lang="scss">
.v-text-field input[readonly="readonly"] {
    color: gray !important;
    transition: color 0.2s ease-in-out;
}
</style>
