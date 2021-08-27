<template>
    <v-app-bar
        flat
        color="transparent"
        class="px-5"
        absolute
    >
        <v-toolbar-title class="cursor-pointer" @click="$router.push('/')">
            <b class="black--text">Intern<span class="green--text text--accent-4">App</span></b>
        </v-toolbar-title>
    </v-app-bar>
</template>

<script>
export default {
    name: "AppBarMinimal"
}
</script>

<style scoped>

</style>
