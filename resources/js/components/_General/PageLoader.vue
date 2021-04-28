<template>
    <v-progress-circular color="primary" size="150" width="8" indeterminate class=""></v-progress-circular>
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
