<template>
    <v-list-item>
        <v-list-item-content>
            <v-list-item-title>{{ name }}</v-list-item-title>
            <v-list-item-subtitle>{{ description }}</v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-action>
            <v-tooltip
                top
                :color="done ? 'primary' : ''"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        icon
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>{{ done ? 'mdi-check' : 'mdi-close' }}</v-icon>
                    </v-btn>
                </template>
                <span>{{ done ? 'Wykonano' : 'W trakcie' }}</span>
            </v-tooltip>

        </v-list-item-action>
    </v-list-item>
</template>

<script>
export default {
name: "InternshipStudentTask",
    props: ['name', 'description', 'done']
}
</script>

<style scoped>

</style>
