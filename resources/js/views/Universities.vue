<template>
    <v-container>
        <v-row v-id="userUniversitiesLoading && userUniversities > 1">
            <v-col cols="12">
                <page-title>Lista uniwersytetów</page-title>
                <universities-list></universities-list>
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col cols="12">
                <v-progress-circular color="primary" size="70" indeterminate></v-progress-circular>
            </v-col>
        </v-row>
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
        return {}
    },

    computed: {
        ...mapGetters({
            userUniversities: 'user/userUniversities',
            userUniversitiesLoading: 'user/userUniversitiesLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchUserUniversities: 'user/fetchUserUniversities',
        }),
    },

    created() {
        this.fetchUserUniversities().then(() => {
            if (this.userUniversities.length === 1) {
                this.$router.push({name: 'university', params: {slug: this.userUniversities[0].slug}});
            }
        }).catch(() => {

        });
    }
}
</script>

<style scoped>

</style>
