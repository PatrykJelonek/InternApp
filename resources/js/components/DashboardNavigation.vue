<template>
    <v-navigation-drawer
        app
        clipped
        v-model="drawer"
        color="white"
        :expand-on-hover="true"
        :mini-variant="true"
        :permanent="true"
    >
        <v-list dense nav>

            <v-list-item link to="/dashboard" color="blue accent-4">
                <v-list-item-icon>
                    <v-icon>mdi-view-dashboard</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item link to="/universities" color="blue accent-4">
                <v-list-item-icon>
                    <v-icon>mdi-school-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Uniwersytety</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-group prepend-icon="mdi-briefcase-outline" no-action color="blue accent-4">
                <template v-slot:activator>
                    <v-list-item-title>Firmy</v-list-item-title>
                </template>
                    <v-list-item link to="/companies">
                        <v-list-item-content>
                            <v-list-item-title>Moje Firmy</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
            </v-list-group>

            <v-list-group prepend-icon="mdi-newspaper-variant-multiple" no-action color="blue accent-4">
                <template v-slot:activator>
                    <v-list-item-title>Oferty</v-list-item-title>
                </template>
                <v-list-item link to="/offers">
                    <v-list-item-content>
                        <v-list-item-title>Wszystkie Oferty</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link to="/create-offer">
                    <v-list-item-content>
                        <v-list-item-title>Utwórz Ofertę</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-group>

        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: "DashboardNavigation",

        data() {
            return {
                drawer: true,
            }
        },
    }
</script>

<style scoped>

</style>
