<template>
    <vuex-tabs-header>
        <v-tab>Dashboard Tab 1</v-tab>
        <v-tab>Dashboard Tab 2</v-tab>
        <v-tab>Dashboard Tab 3</v-tab>
    </vuex-tabs-header>
</template>

<script>
    import VuexTabsHeader from "../_Helpers/VuexTabsHeader";

    export default {
        name: "WelcomeTabs",
        components: {VuexTabsHeader},
    }
</script>

<style scoped>

</style>
