<template>
    <div>
        <v-row>
            <v-col cols="12">
                <the-university-internships-list></the-university-internships-list>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import TheUniversityInternshipsList from "./TheUniversityInternshipsList";
import {mapActions} from "vuex";
export default {
    name: "TheUniversityInternships",
    components: {TheUniversityInternshipsList},

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Uczelnia', to: {name: 'university', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Praktyki i Staże', to: {name: 'university-internships', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
