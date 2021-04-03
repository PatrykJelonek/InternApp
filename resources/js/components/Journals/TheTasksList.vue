<template>
    <div>
        <v-row>
            <v-col cols="12">
                <v-card
                    color="cardBackground"
                    elevation="0"
                    class="pa-3 text-center"
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-icon>mdi-plus</v-icon>
                </v-card>
            </v-col>
        </v-row>
        <v-row no-gutters>
            <v-col cols="12">
                <tasks-list-item
                    v-for="task in tasks"
                    :key="task.id"
                    :name="task.name"
                >
                </tasks-list-item>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import TasksListItem from "../Tasks/TasksListItem";

    export default {
        name: "TheTasksList",
        components: {TasksListItem},
        computed: {
            ...mapGetters({
                tasks: 'task/tasks',
            })
        },

        methods: {
            ...mapActions({
                fetchTasks: 'task/fetchTasks',
            }),
        },

        created() {
            this.fetchTasks(1).then(() => {
                console.log('elo');
            });
        },
    }
</script>

<style scoped>

</style>
