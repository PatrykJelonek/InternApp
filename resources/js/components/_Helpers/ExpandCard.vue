<template>
    <v-card elevation="0" color="card-background">
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">{{ title }}</v-list-item-title>
                    <v-list-item-subtitle>{{ description }}</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn-toggle borderless dense background-color="card-background">
                        <slot name="buttons"></slot>
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
                    </v-btn-toggle>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-expand-transition>
            <v-row v-show="show" no-gutters>
                <v-col cols="12">
                    <slot></slot>
                </v-col>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
export default {
    name: "ExpandCard",
    props: {
        title: String,
        description: String,
        expand: {
            type: Boolean,
            default: true
        }
    },

    data() {
        return {
            show: true
        }
    }
}
</script>

<style scoped>

</style>
