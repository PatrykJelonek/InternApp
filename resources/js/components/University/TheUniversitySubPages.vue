<template>
    <v-card elevation="0" color="card-background">
        <v-tabs grow>
            <v-tab :to="{name: 'university-overview'}">Informacje</v-tab>
            <v-tab :to="{name: 'university-students'}">Studenci</v-tab>
            <v-tab :to="{name: 'university-workers'}">Pracownicy</v-tab>
            <v-tab :to="{name: 'university-agreements'}">Umowy</v-tab>
            <v-tab :to="{name: 'university-internships'}">Praktyki i staże</v-tab>
            <v-tab :to="{name: 'university-settings'}">Ustawienia</v-tab>
        </v-tabs>
    </v-card>
</template>

<script>
export default {
name: "TheUniversitySubPages"
}
</script>

<style scoped>

</style>
