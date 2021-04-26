<template>
    <v-card elevation="0" color="card-background">
        <v-tabs>
            <v-tab
                v-for="tab in tabs"
                :key="tab.name"
                :to="tab.to"
            >
                {{ tab.name }}
            </v-tab>
        </v-tabs>
    </v-card>
</template>

<script>
export default {
    name: "PageTabs",
    props: ['tabs']
}
</script>

<style scoped>

</style>
