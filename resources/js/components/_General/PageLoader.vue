<template>
    <v-overlay color="component-background darken-1" opacity=".2">
        <v-progress-circular color="primary" size="150" width="8" indeterminate></v-progress-circular>
    </v-overlay>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "PageLoader",

    computed: {
        ...mapGetters({}),
    },

    methods: {
        ...mapActions({
            setFillHeight: 'helpers/setFillHeight'
        }),
    },

    created() {
        this.setFillHeight(true);
    },

    destroyed() {
        this.setFillHeight(false);
    }
}
</script>

<style scoped>

</style>
