<template>
    <v-card
        elevation="0"
        color="component-background"
        class="fill-height"
        :loading="loading"
    >
        <template v-slot:progress>
            <v-progress-linear color="primary" indeterminate></v-progress-linear>
        </template>
        <slot></slot>
    </v-card>
</template>

<script>
export default {
    name: "CustomCard",
    props: ['fillHeight','loading'],

    data() {
        return {
            windowHeight: null,
        }
    },

    created() {
        this.windowHeight = window.innerHeight - 168;
    }
}
</script>

<style scoped>

</style>
