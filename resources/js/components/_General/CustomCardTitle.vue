<template>
    <v-row no-gutters>
        <v-col cols="12" class="pa-3">
            <v-row class="d-flex align-center" no-gutters>
                <v-col cols="auto">
                    <h2 class="text--welcome text-subtitle-1 font-weight-bold mb-0">
                        <slot></slot>
                    </h2>
                    <p class="text-body-2 secondary--text pa-0 ma-0" v-if="$slots['subheader']">
                        <slot name="subheader"> </slot>&#32;
                    </p>
                </v-col>
                <v-col class="d-flex justify-end">
                    <v-btn-toggle borderless class="component-background" dense>
                    <slot name="actions"></slot>
                    </v-btn-toggle>
                </v-col>
            </v-row>
        </v-col>
        <v-col cols="12" v-if="!withoutDivider">
            <v-divider></v-divider>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "CustomCardTitle",
    props: ['withoutDivider']
}
</script>

<style scoped>

</style>
