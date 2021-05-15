<template>
    <v-app>
        <v-app-bar app flat>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-app-bar-title></v-app-bar-title>
        </v-app-bar>
        <v-navigation-drawer
            app
            dark
            color="blue-grey darken-4"
        >
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="title">
                        <b>Intern<span class="green--text text--accent-4">App</span></b>
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        Solution
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list nav dense>
                <v-list-item>
                    <v-list-item-title>Dashbaord</v-list-item-title>
                </v-list-item>

                <v-list-group >
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>Uniwersytet</v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item link>
                        <v-list-item-title>Informacje</v-list-item-title>
                    </v-list-item>
                    <v-list-item link>
                        <v-list-item-title>Studenci</v-list-item-title>
                    </v-list-item>
                    <v-list-item link>
                        <v-list-item-title>Pracownicy</v-list-item-title>
                    </v-list-item>
                    <v-list-item link>
                        <v-list-item-title>Umowy</v-list-item-title>
                    </v-list-item>
                    <v-list-item link>
                        <v-list-item-title>Praktyki i Staże</v-list-item-title>
                    </v-list-item>
                    <v-list-item link>
                        <v-list-item-title>Ustawienia</v-list-item-title>
                    </v-list-item>
                </v-list-group>

                <v-list-group>
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>Firma</v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item link>
                        <v-list-item-title>Informacje</v-list-item-title>
                    </v-list-item>
                    <v-list-item link>
                        <v-list-item-title>Oferty Praktyk</v-list-item-title>
                    </v-list-item>
                    <v-list-item link>
                        <v-list-item-title>Umowy</v-list-item-title>
                    </v-list-item>
                    <v-list-item link>
                        <v-list-item-title>Pracownicy</v-list-item-title>
                    </v-list-item>
                    <v-list-item link>
                        <v-list-item-title>Ustawienia</v-list-item-title>
                    </v-list-item>
                </v-list-group>

                <v-list-group>
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>Panel Administratora</v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item-group>
                        <v-list-item link>
                            <v-list-item-icon class="mr-2">
                                <v-icon dense>mdi-monitor-dashboard</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Dashboard</v-list-item-title>
                        </v-list-item>
                        <v-list-item link>
                            <v-list-item-icon class="mr-2">
                                <v-icon dense>mdi-chart-box-outline</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Statystyki</v-list-item-title>
                        </v-list-item>
                        <v-list-item link>
                            <v-list-item-icon class="mr-2">
                                <v-icon dense>mdi-account-group-outline</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Użytkownicy</v-list-item-title>
                        </v-list-item>
                        <v-list-item link>
                            <v-list-item-icon class="mr-2">
                                <v-icon dense>mdi-account-group-outline</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Oferty</v-list-item-title>
                        </v-list-item>
                        <v-list-item link>
                            <v-list-item-icon class="mr-2">
                                <v-icon dense>mdi-application-cog</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Ustawienia</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list-group>
            </v-list>

        </v-navigation-drawer>
    </v-app>
</template>

<script>
export default {
    name: "TestApp",
    data() {
        return {}
    },
}
</script>

<style lang="scss" scoped>

</style>
