<template>
    <v-expansion-panel-header class="mb-5 px-0" color="transparent">
        <h3>
            <v-icon class="ml-2">{{icon}}</v-icon>
            {{title}}
        </h3>
    </v-expansion-panel-header>
</template>

<script>
    export default {
        name: "InternshipColumnHeader",
        props: ['title', 'icon'],
    }
</script>

<style lang="scss" scoped>
    .expansion-panel__container {
        // uncomment below
        background-color: transparent !important;
    }
</style>
