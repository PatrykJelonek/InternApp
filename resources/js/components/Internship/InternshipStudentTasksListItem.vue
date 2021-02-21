<template>
    <v-card
        color="cardBackground"
        elevation="0"
        class="mb-3"
        @click="setPreview(description)"
    >
        <v-list flat two-line color="transparent">
            <v-list-item-group multiple>
                <v-list-item :ripple="false">
                    <v-list-item-content>
                        <v-list-item-title class="text-m font-weight-bold">{{name}}</v-list-item-title>
                        <v-list-item-subtitle>{{description}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-card>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "InternshipStudentTasksListItem",
        props: ['name', 'description'],

        methods: {
            ...mapActions({
                setPreview: 'internship/setPreview'
            }),
        },
    }
</script>

<style scoped>

</style>
