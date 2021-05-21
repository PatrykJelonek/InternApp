<template>
    <div>
        <v-row>
            <v-col cols="12">
                <the-university-workers-list></the-university-workers-list>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import TheUniversityWorkersList from "./TheUniversityWorkersList";
import {mapActions} from "vuex";
export default {
    name: "TheUniversityWorkers",
    components: {TheUniversityWorkersList},

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Uczelnia', to: {name: 'university', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Pracownicy', to: {name: 'university-workers', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
