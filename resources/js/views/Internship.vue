<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" lg="4">
                <the-internship-info-card
                    :v-if="internship !== null && internship.agreement !== null"
                    :internship-name="internship.agreement.program"
                    :internship-start-date="internship.agreement.date_from"
                    :internship-end-date="internship.agreement.date_to"
                ></the-internship-info-card>
            </v-col>
        </v-row>
        <v-row class="mt-10">
            <v-col
                cols="12"
                lg="3"
                v-has="['admin','company_worker','university_worker']"
            >
                <internship-column-header
                    icon="mdi-account-group-outline"
                    title="Studenci"
                ></internship-column-header>
                <the-internship-students-list
                    :internship-id="$route.params.id"
                ></the-internship-students-list>
                <!-- Lista studentów -->
            </v-col>
            <v-col cols="12" lg="3">
                <internship-column-header
                    icon="mdi-text-box-multiple-outline"
                    title="Wpisy"
                ></internship-column-header>
                <!-- Wpisy -->
            </v-col>
            <v-col cols="12" lg="3">
                <internship-column-header
                    icon="mdi-calendar-check"
                    title="Zadania"
                ></internship-column-header>
                <!-- Zadania -->
            </v-col>
            <v-col cols="12" lg="3" class="hidden-md-and-down">
                <internship-column-header
                    icon="mdi-eye-outline"
                    title="Podgląd"
                ></internship-column-header>
                <!-- Podgląd -->
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import TheInternshipInfoCard from "../components/Internship/TheInternshipInfoCard";
    import InternshipColumnHeader from "../components/Internship/InternshipColumnHeader";
    import TheInternshipStudentsList from "../components/Internship/TheInternshipStudentsList";
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "Internship",
        components: {TheInternshipStudentsList, InternshipColumnHeader, TheInternshipInfoCard},

        computed: {
            ...mapGetters({
                currentUser: 'auth/user',
                internship: 'internship/internship'
            })
        },

        methods: {
            ...mapActions({
                fetchJournalEntries: 'journal/fetchJournalEntries',
                fetchInternship: 'internship/fetchInternship'
            }),
        },

        created() {
            this.fetchInternship(this.$route.params.id).then(() => {

            }).catch((e) => {
               console.error(e);
            });




            // if(this.currentUser.roles.find((role) => {
            //     return role.name.toLowerCase() === 'student';
            // })) {
            //     this.fetchJournalEntries({internshipId: 2, studentId: 3}).then(() => {
            //         console.log('MAMY TO');
            //     }).catch((e) => {
            //         console.error("DUMP");
            //     });
            // }
        }
    }
</script>

<style scoped>

</style>
