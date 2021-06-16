<template>
    <custom-card>
        <v-card-title>{{name}}</v-card-title>
        <v-card-subtitle>{{description}}</v-card-subtitle>
    </custom-card>
</template>

<script>
import CustomCard from "../_General/CustomCard";
export default {
    name: "QuestionnairesListItem",
    components: {CustomCard},
    props: ['name', 'description']
}
</script>

<style scoped>

</style>
