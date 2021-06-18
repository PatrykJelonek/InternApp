<template>
    <v-card color="transparent" flat>
        <v-row no-gutters>
            <v-col>
                <v-card-title class="text-h6">{{ name }}</v-card-title>
                <v-card-subtitle class="pb-0">{{ description }}</v-card-subtitle>
            </v-col>
            <v-col class="d-flex justify-end align-center">
                <v-btn-toggle borderless dense>
                    <v-btn icon @click="expand = !expand">
                        <v-icon>{{ expand ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                    </v-btn>
                </v-btn-toggle>
            </v-col>
        </v-row>
        <v-expand-transition>
            <v-row v-if="expand" class="grey lighten-3 mb-1 rounded-0 px-3 pt-3">
                <v-col cols="12">
                    <v-row>
                        <v-col v-if="questions.length > 0" cols="12" v-for="(item, index) in questions" :key="item.id">
                            <v-text-field
                                v-model="questions[index].content"
                                :label="'Pytanie nr '+ (index+1)"
                                dense
                                outlined
                                :value="item.content"
                                hide-details
                                class="d-flex align-center"
                                @change="checkQuestionWasModified"
                                :readonly="item.deleted_at !== null"
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
                                        {{ item.deleted_at === null ? 'mdi-delete-outline' : 'mdi-delete-off-outline' }}
                                    </v-icon>
                                </template>
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" class="text-centers" v-else>
                            <p class="text-h6">Ta ankieta nie posiada jeszcze pytań!</p>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" class="text-center">
                            <v-tooltip bottom color="tooltip-background">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        icon
                                        dark
                                        color="secondary"
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="addQuestionInput"
                                        @change="checkQuestionWasModified"
                                    >
                                        <v-icon>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                <span>Dodaj pytanie</span>
                            </v-tooltip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" class="text-center">
                            <v-btn small outlined @click="addQuestionInput" :disabled="!wasQuestionsModified">
                                Zapisz
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
import {isEqual} from "lodash";
import moment from "moment";
import CustomCard from "../_General/CustomCard";
import ExpandCard from "../_Helpers/ExpandCard";
import VCardHeader from "../_Helpers/VCardHeader";

export default {
    name: "QuestionnairesListItem",
    components: {VCardHeader, ExpandCard, CustomCard},
    props: ['name', 'description', 'isExpand', 'originalQuestions'],

    data() {
        return {
            questions: [],
            expand: false,
            wasQuestionsModified: false,
        }
    },

    methods: {
        addQuestionInput() {
            let {lastId, lastPosition} = this.getLastQuestionData(this.questions);
            this.questions.push({
                id: lastId + 1,
                content: '',
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
            let lastId = questions[0].id;
            let lastPosition = questions[0].position;

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
                this.questions[index+1].position = this.getQuestionOriginalPosition(this.questions[index+1]);
                this.questions.splice(index, 1);
            }

            this.questions = this.sortQuestionsByPosition(this.questions);
            this.checkQuestionWasModified();
        },

        getDate() {
            return this.moment().format();
        }
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
