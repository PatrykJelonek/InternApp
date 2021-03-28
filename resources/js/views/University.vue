<template>
    <h1>{{ university.name }}</h1>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "University",

    computed: {
        ...mapGetters({
            university: 'university/university',
            universityLoading: 'university/universityLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchUniversity: 'university/fetchUniversity',
        }),
    },

    created() {
        this.fetchUniversity(this.$route.params.slug).then(() => {

        }).catch((e) => {

        })
    }
}
</script>

<style scoped>

</style>
