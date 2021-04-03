<template>
    <v-card
        color="cardBackground"
        elevation="0"
        class="pa-3 mb-3 text-center"
        v-bind="attrs"
        v-on="on"
        ripple
    >
        <v-icon>mdi-plus</v-icon>
    </v-card>
</template>

<script>
    export default {
        name: "InternshipDialogActivator"
    }
</script>

<style scoped>

</style>
