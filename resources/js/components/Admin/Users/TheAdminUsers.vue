<template>
    <h1>users</h1>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "TheAdminUsers",

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Panel Administratora', to: {name: 'admin'}, exact: true},
            {text: 'Użytkownicy', disabled: true}
        ]);
    }
}
</script>

<style scoped>

</style>
