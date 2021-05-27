<template>
    <v-row class="mb-2">
        <v-col>
            <h2 class="text--welcome text-h4 font-weight-medium">
                <slot></slot>
            </h2>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "PageTitle",
}
</script>

<style scoped>

</style>
