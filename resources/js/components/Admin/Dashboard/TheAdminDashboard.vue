<template>
    <v-container fluid>
        <h1>Panel Admina</h1>
    </v-container>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "TheAdminDashboard",

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Panel Administratora', to: {name: 'admin'}},
        ]);
    }
}
</script>

<style scoped>

</style>
