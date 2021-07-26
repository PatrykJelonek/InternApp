<template>
    <v-card
        elevation="0"
        color="component-background"
        :class="compact ? '' : 'fill-height'"
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
    props: ['compact','loading'],

    data() {
        return {
            windowHeight: null,
        }
    },

    created() {

    }
}
</script>

<style scoped>

</style>
