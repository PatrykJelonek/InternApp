<template>
    <v-card
        elevation="0"
        color="component-background"
        class="fill-height"
    >
        <slot></slot>
    </v-card>
</template>

<script>
export default {
    name: "CustomCard",
    props: ['fillHeight'],

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
