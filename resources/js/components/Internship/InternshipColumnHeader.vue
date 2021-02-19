<template>
    <v-row>
        <v-col cols="12">
            <h3>
                <v-icon>{{icon}}</v-icon>
                {{title}}
            </h3>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "InternshipColumnHeader",
        props: ['title', 'icon'],
    }
</script>

<style scoped>

</style>
