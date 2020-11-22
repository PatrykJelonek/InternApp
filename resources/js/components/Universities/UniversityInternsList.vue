<template>
    <v-card otulined>
        <v-data-table
            :items="students"
            :headers="headers"
            :items-per-page="10"
            :loading="isLoading"
            no-data-text="Niestety nie ma jeszcze żadnych praktykantów!"
        >
            <template v-slot:item.full_name="{ item }">
               {{item.user.first_name}} {{item.user.last_name}}
            </template>
        </v-data-table>
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
                    {text: 'Indeks', value: 'student_index'},
                    {text: 'Semestr', value: 'semester'},
                    {text: 'Rok Studiów', value: 'study_year'},
                    {text: 'Imię i nazwisko', value: 'full_name'},
                ]
            }
        },

        computed: {
            ...mapGetters({
                selectedUniversityId: 'university/selectedUniversityId',
                students: 'university/students'
            }),
        },

        methods: {
            ...mapActions({
                fetchStudents: 'university/fetchStudents',
            }),
        },

        watch: {
            selectedUniversityId() {
                this.fetchStudents(this.selectedUniversityId).then(() => {
                    this.isLoading = false;
                });
            }
        },

        created() {
            this.fetchStudents(this.selectedUniversityId).then(() => {
                this.isLoading = false;
            });
        }
    }
</script>

<style scoped>

</style>
