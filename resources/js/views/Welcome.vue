<template>
    <v-container fluid >
        <h2>Welcome to the dashboard</h2>

        <vuex-tabs-items>
            <v-tab-item>
                <v-card flat>
                    <v-card-text>1</v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <v-card flat>
                    <v-card-text>2</v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <v-card flat>
                    <v-card-text>3</v-card-text>
                </v-card>
            </v-tab-item>
        </vuex-tabs-items>
    </v-container>
</template>

<script>
    import VuexTabsItems from "../components/_Helpers/VuexTabsItems";

    export default {
        name: "Welcome",
        components: {VuexTabsItems},
    }
</script>

<style scoped>

</style>
