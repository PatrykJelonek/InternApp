<template>
    <v-card
        elevation="0"
        :color="background ? background : 'component-background'"
        :class="compact ? '' : 'fill-height'"
        :loading="loading"
        :ripple="ripple"
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
    props: ['compact', 'loading', 'ripple', 'background'],

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
