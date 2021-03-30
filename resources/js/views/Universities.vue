<template>
    <v-container>
        <page-title>Lista uniwersytetów</page-title>
        <universities-list></universities-list>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import UniversitiesList from "../components/Universities/UniversitiesList";
import PageTitle from "../components/_Helpers/PageTitle";

export default {
    name: "Universities",
    props: ['tab'],
    components: {
        PageTitle,
        UniversitiesList,
    },

    data() {
        return {

        }
    }

}
</script>

<style scoped>

</style>
