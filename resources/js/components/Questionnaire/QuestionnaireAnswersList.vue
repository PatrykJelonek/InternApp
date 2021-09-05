<template>
    <custom-card
        title="Odpowiedzi"
        :description="'Lista odpowiedzi na pytania z ankiety ' + questionnaire.name"
    >
        <custom-card-title class="mb-2">
            <template v-slot:default>Odpowiedzi</template>
            <template v-slot:subheader>Lista odpowiedzi na pytania z ankiety {{ questionnaire.name }}</template>
        </custom-card-title>

        <v-row class="px-5 py-2" v-if="questionnaireAnswers" no-gutters>
            <v-col cols="12" v-for="(questionnaireAnswersGroup, session_uuid) in questionnaireAnswers"
                   :key="session_uuid" class="mb-2">
                <v-row class="d-flex align-center">
                    <v-col cols="auto" class="d-flex flex-column">
                        <v-row>
                            <v-col cols="12" class="d-flex align-center">
                                <v-avatar
                                    :size="20"
                                    rounded
                                    class="mr-2"
                                    :color="questionnaireAnswersGroup[0].user.avatar_url ? '' : 'primary'"
                                >
                                    <v-img
                                        :src="questionnaireAnswersGroup[0].user.avatar_url ? '/'+questionnaireAnswersGroup[0].user.avatar_url : ''"
                                        :alt="'Awatar użytkownika ' + questionnaireAnswersGroup[0].user.full_name"
                                    ></v-img>
                                </v-avatar>
                                {{
                                    questionnaireAnswersGroup[0].user.full_name
                                }}
                            </v-col>
                        </v-row>

                        <span class="pa-0 text--secondary text-caption">
                            {{ formatDate(questionnaireAnswersGroup[0].created_at) }}
                        </span>
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
                    <v-row v-if="isExpanded.includes(session_uuid)" class="mb-5">
                        <v-col cols="12" v-for="(answer, index) in questionnaireAnswersGroup" :key="answer.id"
                               class="d-flex flex-column py-1 rounded "
                               v-bind:class="index % 2 === 0 ? 'component-background lighten-1' : ''">
                            <span class="pa-0 text--secondary text-body-2">{{ answer.question.content }}</span>
                            <p class="mb-0">{{ answer.content }}</p>
                        </v-col>
                    </v-row>
                </v-expand-transition>
            </v-col>
        </v-row>
        <v-row class="d-flex justify-center align-center" v-else>
            <v-col cols="12">
                <p class="pt-5 pb-3 secondary--text text-center">Jeszcze nikt nie wypełnił tej ankiety!</p>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import ExpandCard from "../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";

export default {
    name: "QuestionnaireAnswersList",
    components: {CustomCardTitle, CustomCard, ExpandCard},

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
            console.log(this.questionnaireAnswers.length);
        }).catch((e) => {
            console.log(e.response)
        });
    },
}
</script>

<style scoped>

</style>
