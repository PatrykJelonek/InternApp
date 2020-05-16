<template>
    <v-app>
        <dashboard-navigation></dashboard-navigation>
        <v-content class="grey lighten-5">
            <v-container fluid class="pa-10">
                <router-view></router-view>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import DashboardNavigation from "../components/DashboardNavigation";
    export default {
        components: {DashboardNavigation},
        data() {
            return {
                drawer: true,
                permament: true,
                miniVariant: true,
                expandOnHover: true,
                background: false,
            }
        }
    }
</script>

<style scoped>

</style>
