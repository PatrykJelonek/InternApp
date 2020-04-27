<template>
    <v-app>
        <v-container>
            <v-row>
                <v-col lg="3">
                    <v-btn small color="primary">Hello</v-btn>
                </v-col>
                <v-col lg="9">
                    <v-btn small color="error">World</v-btn>
                </v-col>
                <v-col>
                    Hello World
                </v-col>
            </v-row>
        </v-container>
        <user-statuses></user-statuses>
    </v-app>
</template>

<script>
    import UserStatuses from "./UserStatuses";

    export default {
        components: {
            'user-statuses': UserStatuses,
        }
    }
</script>

<style scoped>

</style>
