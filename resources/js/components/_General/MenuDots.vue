<template>
    <v-menu offset-y left>
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                icon
                rounded
                v-bind="attrs"
                v-on="on"
            >
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
        </template>
        <v-list dense menu color="component-background lighten-1">
            <slot name="items"></slot>
        </v-list>
    </v-menu>
</template>

<script>
export default {
    name: "MenuDots"
}
</script>

<style scoped>

</style>
