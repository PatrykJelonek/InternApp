<template>
    <v-breadcrumbs
        :items="$route.meta.breadcrumbs"
        divider="/"
    ></v-breadcrumbs>
</template>

<script>
export default {
    name: "TheAppBreadcrumbs",

    data() {
        return {
            breadcrumbs: []
        }
    },

    created() {

    }
}
</script>

<style scoped>

</style>
