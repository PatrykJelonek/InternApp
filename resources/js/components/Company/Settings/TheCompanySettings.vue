<template>
    <h1>Settings</h1>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "TheCompanySettings",

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Firma', to: {name: 'company', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Ustawienia', to: {name: 'company-settings'}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
