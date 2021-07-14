<template>
    <div>
        <v-row no-gutters>
            <v-col cols="12">
                <v-divider></v-divider>
            </v-col>
        </v-row>
        <v-row no-gutters class="d-flex justify-space-between px-5 py-4">
            <v-col cols="auto">
                <slot name="left"></slot>
            </v-col>
            <v-col cols="auto">
                <slot name="right"></slot>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    name: "CustomCardFooter"
}
</script>

<style scoped>

</style>
