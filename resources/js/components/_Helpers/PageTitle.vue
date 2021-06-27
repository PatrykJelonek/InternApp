<template>
    <custom-card class="mb-10 pa-5">
        <v-row class="d-flex align-center" no-gutters>
            <v-col cols="auto">
                <h2 class="text--welcome text-h5 font-weight-bold mb-0">
                    <slot></slot>
                </h2>
                <p class="text-body-2 secondary--text pa-0 ma-0" v-if="$slots['subheader']">
                    <slot name="subheader"> </slot>&#32;
                </p>
            </v-col>
            <v-col class="d-flex justify-end">
                <slot name="actions"></slot>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import CustomCard from "../_General/CustomCard";
export default {
    name: "PageTitle",
    components: {CustomCard},

}
</script>

<style scoped>

</style>
