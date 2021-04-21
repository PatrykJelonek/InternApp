<template>
    <v-list-item two-line ripple :to="{name: 'internship', params: {internshipId: id}}">
        <v-list-item-content>
            <v-list-item-title>{{ name }}</v-list-item-title>
            <v-list-item-subtitle>{{ company }}</v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-content>
            <v-sparkline
                :value="getSparklineData()"
                smooth="20"
                line-width=".5"
                padding="10"
                width="50"
                height="10"
                stroke-linecap="round"
                auto-draw
            ></v-sparkline>
        </v-list-item-content>
        <v-list-item-action>
            <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
        </v-list-item-action>
    </v-list-item>
</template>

<script>
export default {
    name: "DashboardInternshipsItem",
    props: ['name', 'company', 'journalEntriesStats','id'],

    methods: {
        getSparklineData() {
            if(this.journalEntriesStats.length < 1) {
                return [0];
            }

            return this.journalEntriesStats;
        }
    }
}
</script>

<style scoped>

</style>
