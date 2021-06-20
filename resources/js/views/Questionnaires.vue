<template>
    <h1>Ankiety</h1>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "Questionnaires",

    methods: {
        ...mapActions({
            fetchQuestionnaire: 'questionnaire/fetchQuestionnaire',
            setBreadcrumbs: 'helpers/setBreadcrumbs',
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Ankiety', to: {name: 'questionnaires'}, exact: true},
        ]);
    }
}
</script>

<style scoped>

</style>
