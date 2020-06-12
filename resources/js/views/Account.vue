<template>
    <v-container fluid class="pa-0">
        <page-details-header :header="user.first_name +' '+ user.last_name" :subheader="user.email"></page-details-header>
    </v-container>
</template>

<script>
    import {mapGetters} from "vuex";
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";

    export default {
        name: "Account",
        components: {PageDetailsHeader},
        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
        },
    }
</script>

<style scoped>
</style>
