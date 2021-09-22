<template>
    <v-dialog
        v-model="dialogState"
        class="component-background"
        persistent
        max-width="600"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>{{ title }}</template>
                <template v-slot:subheader v-if="this.$slots.default">{{ subheader }}</template>
            </custom-card-title>
            <v-row no-gutters v-if="description">
                <v-col cols="12" class="pa-5 text-body-2 hyphens-auto">
                    {{ description }}
                </v-col>
            </v-row>
            <v-row no-gutters >
                <v-col cols="12" class="pa-5">
                    <template v-if="this.$slots.default">
                        <slot></slot>
                    </template>
                    <template v-else>
                        {{ subheader }}
                    </template>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-card-actions>
                <v-row class="pa-2">
                    <v-col cols="6">
                        <v-btn outlined color="secondary" @click="toggle">Anuluj</v-btn>
                    </v-col>
                    <v-col cols="6" class="text-right">
                        <v-btn outlined color="primary" @click="confirmFunction(...confirmFunctionArgs)">
                            {{ confirmBtnText ? confirmBtnText : 'Potwierdź' }}
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </custom-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../_Helpers/ExpandCard";
import CustomCard from "./CustomCard";
import CustomCardTitle from "./CustomCardTitle";

export default {
    name: "CustomConfirmDialog",
    components: {CustomCardTitle, CustomCard, ExpandCard},
    props: {
        toggleFunction: Function,
        confirmFunction: Function,
        confirmFunctionArgs: Array,
        dialogState: Boolean,
        title: String,
        subheader: String,
        description: String,
        dialogKey: String,
        confirmBtnText: String,
    },

    methods: {
        toggle() {
            if (this.dialogKey) {
                this.toggleFunction({
                    key: this.dialogKey,
                    val: false
                });
            } else {
                this.toggleFunction(false)
            }
        },
    }
}
</script>

<style scoped>
.hyphens-auto {
    hyphens: auto;
}
</style>
