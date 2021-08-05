<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Dołącz do uczelni</template>
            <template v-slot:subheader>Użyj kodu udostępnionego Tobie przez uczelnie lub dodaj nową uczelnie.</template>
            <template v-slot:actions></template>
        </page-title>

        <v-row>
            <v-col cols="12">
                
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import PageTitle from "../components/_Helpers/PageTitle";
export default {
    name: "JoinToUniversity",
    components: {PageTitle}
}
</script>

<style scoped>

</style>
