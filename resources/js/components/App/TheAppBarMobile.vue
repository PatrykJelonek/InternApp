<template>
    <v-app-bar
        app
        flat
        hide-on-scroll
        color="transparent"
    >
        <v-icon
            @click="$router.go(-1)"
            v-if="$route.name !== 'dashboard'"
        >mdi-arrow-left</v-icon>
        <v-spacer></v-spacer>
        <v-toolbar-title class="font-m font-weight-bold">{{$route.meta.title ? $route.meta.title : ""}}</v-toolbar-title>
    </v-app-bar>
</template>

<script>
export default {
    name: "TheAppBarMobile"
}
</script>

<style scoped>

</style>
