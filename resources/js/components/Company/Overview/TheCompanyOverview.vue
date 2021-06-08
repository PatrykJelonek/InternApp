<template>
    <h1>Overview</h1>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "TheCompanyOverview",

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Firma', to: {name: 'company', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
