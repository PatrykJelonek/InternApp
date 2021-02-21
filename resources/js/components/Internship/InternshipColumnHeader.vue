<template>
    <h3 class="mb-5">
        <v-icon class="ml-2">{{icon}}</v-icon>
        {{title}}
    </h3>
</template>

<script>
    export default {
        name: "InternshipColumnHeader",
        props: ['title', 'icon'],
    }
</script>

<style scoped>

</style>
