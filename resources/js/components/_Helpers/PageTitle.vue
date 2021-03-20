<template>
    <v-row class="my-10">
        <v-col>
            <h2 class="text--welcome text-h3 font-weight-black">
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
