<template>
    <v-card elevation="0">
        <v-card-title>Praktyki</v-card-title>
        <v-card-subtitle>Ponieżej znajduje się lista praktyk którymi się opiekujesz.</v-card-subtitle>
        <v-divider></v-divider>
        <v-list nav>
            <v-list-item two-line ripple to="/internships/1">
                <v-list-item-content>
                    <v-list-item-title>Praktyka Programistyczna</v-list-item-title>
                    <v-list-item-subtitle>Polcom Software</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-content>
                    <v-sparkline
                    :value="[1,3,5,2,3,3,1,2]"
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
            <v-list-item two-line ripple>
                <v-list-item-content>
                    <v-list-item-title>Akademia Mechaniczna</v-list-item-title>
                    <v-list-item-subtitle>Polcom Software</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-content>
                    <v-sparkline
                        :value="[4,2,6,5,2,1,2,4]"
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
        </v-list>
    </v-card>
</template>

<script>
import DashboardInternshipsCard from "./DashboardInternshipsCard";

export default {
    name: "TheDashboardInternships",
    components: {DashboardInternshipsCard}
}
</script>

<style scoped>

</style>
