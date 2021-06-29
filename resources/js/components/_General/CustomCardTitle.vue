<template>
    <v-row no-gutters class="mb-2">
        <v-col cols="12" class="pa-3">
            <h2 class="text--welcome text-subtitle-1 font-weight-bold mb-0">
                <slot></slot>
            </h2>
            <p class="text-body-2 secondary--text pa-0 ma-0" v-if="$slots['subheader']">
                <slot name="subheader"> </slot>&#32;
            </p>
        </v-col>
        <v-col cols="12">
            <v-divider></v-divider>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "CustomCardTitle"
}
</script>

<style scoped>

</style>
