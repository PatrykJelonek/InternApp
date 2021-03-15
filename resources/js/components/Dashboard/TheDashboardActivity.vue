<template>
    <v-card elevation="0">
        <v-card-title>Aktywność</v-card-title>
        <v-card-subtitle>Ponieżej znajduje się lista aktywności użytkowników powiązanych z twoim kontem.</v-card-subtitle>
        <v-divider></v-divider>
        <v-list nav>
            <v-list-item ripple to="/internships/1">
                <v-list-item-content>
                    <v-list-item-title>Nowy wpis w Praktyka Programistyczna</v-list-item-title>
                    <v-list-item-subtitle>Adam Marcinkowski</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-content>
                    <v-list-item-title>
                        <v-chip small outlined color="primary">
                            24.02.2021
                        </v-chip>
                    </v-list-item-title>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn icon>
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </v-list-item-action>
            </v-list-item>
            <v-list-item ripple to="/internships/1">
                <v-list-item-content>
                    <v-list-item-title>Nowy wpis w Praktyka Programistyczna</v-list-item-title>
                    <v-list-item-subtitle>Adam Marcinkowski</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-content>
                    <v-list-item-title>
                        <v-chip small outlined color="primary">
                            24.02.2021
                        </v-chip>
                    </v-list-item-title>
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
export default {
    name: "TheDashboardActivity",

    data() {
        return {
            page: 1,
        }
    }
}
</script>

<style scoped>

</style>
