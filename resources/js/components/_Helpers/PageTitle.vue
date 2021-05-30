<template>
    <v-row class="mb-2">
        <v-col>
            <h2 class="text--welcome text-h5 font-weight-bold">
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
