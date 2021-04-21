<template>
    <div>
        <v-row>
            <v-col cols="12">
                <the-university-workers-list></the-university-workers-list>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import TheUniversityWorkersList from "./TheUniversityWorkersList";
export default {
    name: "TheUniversityWorkers",
    components: {TheUniversityWorkersList}
}
</script>

<style scoped>

</style>
