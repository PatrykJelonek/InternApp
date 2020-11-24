<template>
    <v-tabs-items v-model="activeTab">
        <slot></slot>
    </v-tabs-items>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "VuexTabsItems",
        computed: {
            ...mapGetters({
                activeTab: 'tabs/activeTab',
            }),
        },
    }
</script>

<style scoped>

</style>
