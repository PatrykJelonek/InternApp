<template>
    <v-navigation-drawer
        app
        v-model="drawer"
        color="blue accent-4"
        :expand-on-hover="expandOnHover"
        :mini-variant="miniVariant"
        :permanent="permament"
        absolute
        dark
    >
        <v-list-item class="px-2">
            <v-list-item-avatar>
                <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
            </v-list-item-avatar>

            <v-list-item-title class="font-weight-bold">Patryk Jelonek</v-list-item-title>
        </v-list-item>


        <v-divider></v-divider>

        <v-list dense nav>
            <v-list-item link to="dashboard">
                <v-list-item-icon>
                    <v-icon>mdi-view-dashboard</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item link to="universities">
                <v-list-item-icon>
                    <v-icon>mdi-school-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Uniwersytety</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-group
                prepend-icon="mdi-briefcase-outline"
                color="white"
                no-action
            >
                <template v-slot:activator>
                    <v-list-item-title>Firmy</v-list-item-title>
                </template>
                    <v-list-item link to="companies">
                        <v-list-item-content>
                            <v-list-item-title>Moje Firmy</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item link to="companies/create">
                        <v-list-item-content>
                            <v-list-item-title>Dodaj Firmę</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
            </v-list-group>



        </v-list>

        <template v-slot:append>
            <v-list-item link dense to="logout">
                <v-list-item-icon>
                    <v-icon>mdi-exit-to-app</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Wyloguj</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: "DashboardNavigation",
        data() {
            return {
                drawer: true,
                permament: true,
                miniVariant: true,
                expandOnHover: true,
                background: false,
                miniVariant: false,
            }
        }
    }
</script>

<style scoped>

</style>
