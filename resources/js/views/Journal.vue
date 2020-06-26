<template>
    <v-container fluid class="ma-0 pa-0">
        <page-details-header header="Dziennik Praktyk" subheader="W tym miejscu znajdziesz wszystkie swoje wpisy w dzienniku praktyk!"></page-details-header>
        <v-container class="mt-10">
            <v-row>
                <v-col class="d-flex justify-end">
                    <journal-form-modal></journal-form-modal>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <journals-list></journals-list>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import JournalsList from "../components/Journals/JournalsList";
    import JournalFormModal from "../components/Journals/JournalFormModal";
    export default {
        name: "Journal",
        components: {JournalFormModal, JournalsList, PageDetailsHeader}
    }
</script>

<style scoped>

</style>
