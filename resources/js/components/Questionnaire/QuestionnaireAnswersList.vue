<template>
    <expand-card
        title="Odpowiedzi"
        :description="'Lista odpowiedzi na pytania z ankiety ' + questionnaire.name"
    ></expand-card>
</template>

<script>
import ExpandCard from "../_Helpers/ExpandCard";
import {mapGetters} from "vuex";

export default {
    name: "QuestionnaireAnswersList",
    components: {ExpandCard},

    computed: {
        ...mapGetters({
            questionnaire: 'questionnaire/questionnaire',
        }),
    },
}
</script>

<style scoped>

</style>
