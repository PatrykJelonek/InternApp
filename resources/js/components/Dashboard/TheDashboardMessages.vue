<template>
    <v-card elevation="0" color="card-background">
        <v-card-title>Wiadomości</v-card-title>
        <v-card-subtitle>Lista wiadomości otrzymanych od innych użytkowników.</v-card-subtitle>
        <v-divider></v-divider>
        <v-list nav color="card-background">
            <v-list-item two-line to="/messages/1">
                <v-list-item-content>
                    <v-list-item-title>Joanna Panek</v-list-item-title>
                    <v-list-item-subtitle>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam lorem dolor,
                        faucibus a sem feugiat, dictum aliquam massa. Sed sed lacinia tellus.
                    </v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-chip small outlined color="primary" label>20.03.2021</v-chip>
                </v-list-item-action>
            </v-list-item>
            <v-list-item two-line to="/messages/2">
                <v-list-item-content>
                    <v-list-item-title>Mateusz Kowalczyk</v-list-item-title>
                    <v-list-item-subtitle>Nam lorem dolor,
                        faucibus a sem feugiat, dictum aliquam massa. Sed sed lacinia tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-chip small outlined color="primary" label>18.03.2021</v-chip>
                </v-list-item-action>
            </v-list-item>
        </v-list>
    </v-card>
</template>

<script>
export default {
    name: "TheDashboardMessages",

    data() {
        return {
            page: 1
        }
    }
}
</script>

<style scoped>

</style>
