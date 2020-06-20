<template>
    <v-container fluid class="pa-0 ma-0">
        <page-details-header
            header="Praktyki i Staże"
            subheader="W tym miejscu znajdziesz aktualne oferty praktyk i staży dostępnych na przypisanych do konta uczelniach!">
        </page-details-header>
        <v-container class="mt-10">
            <v-row>
                <v-col>
                    <internships-list></internships-list>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import InternshipsList from "../components/Internships/InternshipsList";
    export default {
        name: "Internships",
        components: {InternshipsList, PageDetailsHeader}
    }
</script>

<style scoped>

</style>
