<template>
    <v-card elevation="0" color="card-background">
        <v-card-title>Osoby</v-card-title>
        <v-card-subtitle>Lista użytkowników z twojej firmy.</v-card-subtitle>
        <v-divider></v-divider>
        <v-list nav color="card-background">
            <v-list-item two-line to="/others">
                <v-list-item-content>
                    <v-list-item-title>Katarzyna Ratus</v-list-item-title>
                    <v-list-item-subtitle>kasia.r@pol.com</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn icon>
                        <v-icon dense>mdi-message-plus-outline</v-icon>
                    </v-btn>
                </v-list-item-action>
            </v-list-item>
            <v-list-item two-line to="/others">
                <v-list-item-content>
                    <v-list-item-title>Adam Kowalski</v-list-item-title>
                    <v-list-item-subtitle>adam.kowlaski@pwsz.elblag.pl</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn icon>
                        <v-icon dense>mdi-message-plus-outline</v-icon>
                    </v-btn>
                </v-list-item-action>
            </v-list-item>
        </v-list>
    </v-card>
</template>

<script>
export default {
    name: "TheDashboardOthers"
}
</script>

<style scoped>

</style>
