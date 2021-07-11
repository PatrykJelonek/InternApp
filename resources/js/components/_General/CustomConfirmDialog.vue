<template>
    <v-dialog
        v-model="dialogState"
        class="component-background"
        persistent
        max-width="600"
    >
        <expand-card :title="title" :description="subheader" :expand="false">
            <v-row no-gutters>
                <v-col cols="12" class="pa-5 text-body-1 hyphens-auto">
                    {{ description }}
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-card-actions>
                <v-row class="pa-2">
                    <v-col cols="6">
                        <v-btn outlined color="secondary" @click="toggleFunction(false)">Anuluj</v-btn>
                    </v-col>
                    <v-col cols="6" class="text-right">
                        <v-btn outlined color="primary" @click="confirmFunction(...confirmFunctionArgs)">Potwierdź</v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </expand-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../_Helpers/ExpandCard";

export default {
    name: "CustomConfirmDialog",
    components: {ExpandCard},
    props: {
        toggleFunction: Function,
        confirmFunction: Function,
        confirmFunctionArgs: Array,
        dialogState: Boolean,
        title: String,
        subheader: String,
        description: String,
    }
}
</script>

<style scoped>
    .hyphens-auto {
        hyphens: auto;
    }
</style>
