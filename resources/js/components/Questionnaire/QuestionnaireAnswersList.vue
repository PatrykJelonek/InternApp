<template>
    <expand-card
        title="Odpowiedzi"
        :description="'Lista odpowiedzi na pytania z ankiety ' + questionnaire.name"
    >
        <v-row class="pa-5">
            <v-col cols="12" v-for="(questionnaireAnswersGroup, session_uuid) in questionnaireAnswers"
                   :key="session_uuid">
                <v-row class="d-flex align-center">
                    <v-col cols="auto" class="d-flex flex-column">
                        {{
                            questionnaireAnswersGroup[0].user.first_name + ' ' + questionnaireAnswersGroup[0].user.last_name
                        }}
                        <span class="pa-0 text--secondary text-caption">{{ formatDate(questionnaireAnswersGroup[0].created_at) }}</span>
                    </v-col>
                    <v-col class="d-flex justify-end">
                        <v-btn icon
                               @click="isExpanded.includes(session_uuid) ? isExpanded.splice(isExpanded.indexOf(session_uuid),1) : isExpanded.push(session_uuid)">
                            <v-icon>{{ isExpanded.includes(session_uuid) ? 'mdi-chevron-up' : 'mdi-chevron-down' }}
                            </v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
                <v-expand-transition>
                    <v-row v-if="isExpanded.includes(session_uuid)">
                        <v-col cols="12" v-for="(answer, index) in questionnaireAnswersGroup" :key="answer.id" class="d-flex flex-column py-1 rounded " v-bind:class="index % 2 === 0 ? 'grey lighten-3' : ''">
                            <span class="pa-0 text--secondary text-body-2">{{ answer.question.content }}</span>
                            <p class="mb-0">{{ answer.content }}</p>
                        </v-col>
                    </v-row>
                </v-expand-transition>
            </v-col>
        </v-row>
    </expand-card>
</template>

<script>
import ExpandCard from "../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import moment from "moment";

export default {
    name: "QuestionnaireAnswersList",
    components: {ExpandCard},

    data() {
        return {
            isExpanded: [],
        }
    },

    computed: {
        ...mapGetters({
            questionnaire: 'questionnaire/questionnaire',
            questionnaireAnswers: 'questionnaire/questionnaireAnswers'
        }),
    },

    methods: {
        ...mapActions({
            fetchQuestionnaireAnswers: 'questionnaire/fetchQuestionnaireAnswers',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY - HH:mm')
        }
    },

    created() {
        this.fetchQuestionnaireAnswers(this.$route.params.questionnaireId).then((response) => {

        }).catch((e) => {
            console.log(e.response)
        });
    },
}
</script>

<style scoped>

</style>
