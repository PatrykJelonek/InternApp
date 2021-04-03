<template>
    <div>
        <v-row>
            <v-col cols="12">
                <the-university-agreements-list></the-university-agreements-list>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import TheUniversityAgreementsList from "./TheUniversityAgreementsList";

export default {
    name: "TheUniversityAgreements",
    components: {TheUniversityAgreementsList}
}
</script>

<style scoped>

</style>
