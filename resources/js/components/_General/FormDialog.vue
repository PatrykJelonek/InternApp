<template>
    <v-dialog
        v-model="dialog"
        persistent
        :max-width="maxWidth ? maxWidth : '800px'"
    >
        <expand-card
            :title="title"
            :description="description"
            :expand="false"
        >
            <template slot="buttons">
                <v-tooltip v-if="expand" top>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            small
                            icon
                            v-bind="attrs"
                            v-on="on"
                            @click="show = !show">
                            <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </template>
                    <span>{{ show ? 'Zwiń Listę' : 'Rozwiń Listę' }}</span>
                </v-tooltip>
            </template>
            <slot></slot>
        </expand-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../_Helpers/ExpandCard";

export default {
    name: "FormDialog",
    components: {ExpandCard},
    props: ['dialog', 'toggleFunction', 'title', 'description' , 'expand', 'maxWidth'],
    data() {
        return {
            show: true,
        }
    }
}
</script>

<style scoped>

</style>
