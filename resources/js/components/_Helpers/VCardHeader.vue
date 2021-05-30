<template>
    <div>
        <v-card-title class="px-5 d-flex justify-space-between">
            <span class="text-h6 font-weight-medium">{{ title }}</span>
            <slot name="actions"></slot>
        </v-card-title>
        <v-divider></v-divider>
    </div>
</template>

<script>
export default {
    name: "VCardHeader",
    props: ['title']
}
</script>

<style scoped>

</style>
