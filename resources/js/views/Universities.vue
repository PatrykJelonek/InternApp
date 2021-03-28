<template>
    <v-container>
        <universities-list></universities-list>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import UniversitiesList from "../components/Universities/UniversitiesList";

export default {
    name: "Universities",
    props: ['tab'],
    components: {
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
