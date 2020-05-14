<template>
    <v-app>
        <dashboard-navigation></dashboard-navigation>
        <v-content>
            <v-container>
                <router-link tag="li" to="/">Home</router-link>
                <router-link tag="li" to="add-user-status">Add User Status</router-link>

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
