<template>
    <v-card
        color="cardBackground"
        elevation="0"
        class="mb-3"
    >
        <v-list flat two-line color="transparent">
            <v-list-item-group multiple>
                <v-list-item :ripple="false">
                    <v-list-item-content>
                        <v-list-item-title class="text-m font-weight-bold">
                            {{name}}
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-m success--text">
                            Wykonane
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-card>
</template>

<script>
    export default {
        name: "TasksListItem",
        props: ['name'],
    }
</script>

<style scoped>

</style>
