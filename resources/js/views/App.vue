<template>
    <v-app>
        <v-navigation-drawer
            app
            v-model="drawer"
            :color="color"
            :expand-on-hover="expandOnHover"
            :mini-variant="miniVariant"
            :permanent="permament"
            absolute
            dark
        >

        </v-navigation-drawer>
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
    export default {
        data() {
            return {
                drawer: true,
                color: 'primary',
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
