<template>
    <div>
        <the-university-students-list></the-university-students-list>
    </div>
</template>

<script>
import TheUniversityStudentsList from "./TheUniversityStudentsList";
import {mapActions} from "vuex";
export default {
    name: "TheUniversityStudents",
    components: {TheUniversityStudentsList},

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Uczelnia', to: {name: 'university', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Studenci', to: {name: 'university-students', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
