<template>
    <div>
        <v-row>
            <v-col cols="12">
                <the-university-settings-form></the-university-settings-form>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="8">
                <the-university-faculties></the-university-faculties>
            </v-col>
            <v-col cols="4">
                <the-university-access-code></the-university-access-code>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import TheUniversityFaculties from "./TheUniversityFaculties";
import TheUniversitySettingsForm from "./TheUniversitySettingsForm";
import TheUniversityAccessCode from "./TheUniversityAccessCode";
export default {
    name: "TheUniversitySettings",
    components: {TheUniversityAccessCode, TheUniversitySettingsForm, TheUniversityFaculties}
}
</script>

<style scoped>

</style>
