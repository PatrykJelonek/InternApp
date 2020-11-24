<template>
    <v-tabs
        align-with-title
        background-color="transparent"
        color="secondary"
        class="border"
        @change="(tab) => setActiveTab(tab)"
    >
        <v-tabs-slider color="accent"></v-tabs-slider>
        <slot></slot>
    </v-tabs>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "VuexTabs",
        methods: {
            ...mapActions({
                setActiveTab: 'tabs/setActiveTab',
            }),
        },
        created() {
            this.setActiveTab(this.tab ? this.tab : 0);
        }
    }

</script>

<style scoped>

</style>
