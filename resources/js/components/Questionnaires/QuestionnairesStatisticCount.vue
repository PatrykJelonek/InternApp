<template>
    <custom-card>
        <v-card-subtitle class="pb-0">Liczba ankiet</v-card-subtitle>
        <v-card-title class="text-h2 pt-0">{{numberOfQuestionnaires}}</v-card-title>
    </custom-card>
</template>

<script>
import CustomCard from "../_General/CustomCard";
export default {
    name: "QuestionnairesStatisticCount",
    components: {CustomCard},
    props: ['numberOfQuestionnaires']
}
</script>

<style scoped>

</style>
