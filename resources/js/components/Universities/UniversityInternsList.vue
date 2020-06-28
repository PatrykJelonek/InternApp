<template>
    <v-card otulined>
        <v-data-table
            :items="internships"
            :headers="headers"
            :items-per-page="10"
            :loading="isLoading"
            no-data-text="Niestety nie ma jeszcze żadnych praktykantów!"
        ></v-data-table>
    </v-card>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "UniversityInternsList",

        data() {
            return {
                isLoading: true,
                headers: [
                    {text: 'student id', value: 'student_id'},
                ]
            }
        },

        computed: {
            ...mapGetters({
                selectedUniversityId: 'university/selectedUniversityId',
                internships: 'university/internships'
            }),
        },

        methods: {
            ...mapActions({
                fetchInternships: 'university/fetchInternships',
            }),
        },

        watch: {
            selectedUniversityId() {
                this.fetchInternships(this.selectedUniversityId).then(() => {
                    this.isLoading = false;
                });
            }
        },

        created() {
            this.fetchInternships(this.selectedUniversityId).then(() => {
                this.isLoading = false;
            });
        }
    }
</script>

<style scoped>

</style>
