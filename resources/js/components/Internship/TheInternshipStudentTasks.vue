<template>
    <v-card elevation="0" color="card-background">
        <template slot="progress">
            <v-progress-linear color="primary" indeterminate></v-progress-linear>
        </template>
        <v-card-title>Wpisy</v-card-title>
        <v-card-subtitle>Wybierz jednego ze studentów z poniższej listy by zobaczyć jego wpisy i zadania w dzienniku praktyk.</v-card-subtitle>
        <v-divider></v-divider>
        <v-row v-if="true">
            <v-col cols="12">
                <v-list nav>
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title></v-list-item-title>
                            <v-list-item-subtitle></v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-col>
        </v-row>
        <v-row v-else-if="false">
            <v-col cols="12" class="text-center pt-8">
                <p class="text--secondary">Ten student nie dodał jeszcze wpisów do swojego dziennika praktyk.</p>
            </v-col>
        </v-row>
    </v-card>
    <v-row v-else>
        <v-col cols="12" class="text-center pt-8">
            <p class="text--secondary">Nie wybrano studenta.</p>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "TheInternshipStudentTasks"
}
</script>

<style scoped>

</style>
