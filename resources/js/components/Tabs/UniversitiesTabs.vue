<template>
    <v-tabs
        align-with-title
        background-color="transparent"
        color="secondary"
        class="border"
        v-model="tab"
    >
        <v-tabs-slider color="accent"></v-tabs-slider>
        <v-tab>Info</v-tab>
        <v-tab>Umowy</v-tab>
        <v-tab>Praktyki</v-tab>
        <v-tab>Studenci</v-tab>
        <v-tab>Ustawienia</v-tab>
    </v-tabs>
</template>

<script>
    export default {
        name: "UniversitiesTabs",
        props: ['tab']
    }
</script>

<style scoped>

</style>
