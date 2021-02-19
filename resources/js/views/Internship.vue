<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" lg="4">
                <the-internship-info-card
                    internship-name="Furgonetka"
                    internship-start-date="2020.10.05"
                    internship-end-date="2021.03.23"
                ></the-internship-info-card>
            </v-col>
        </v-row>
        <v-row class="mt-10">
            <v-col
                cols="12"
                lg="3"
                v-has="['admin']"
            >
                <internship-column-header
                    icon="mdi-account-group-outline"
                    title="Studenci"
                ></internship-column-header>
                <the-internship-students-list
                    :agreement-id="$route.params.agreementId"
                >

                </the-internship-students-list>
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
            })
        },

        methods: {
            ...mapActions({
                fetchJournalEntries: 'journal/fetchJournalEntries',
            }),
        },

        created() {
            console.log(this.currentUser.roles);
            if(this.currentUser.roles.find((role) => {
                return role.name.toLowerCase() === 'student';
            })) {
                this.fetchJournalEntries({agreementId: 2, studentId: 3}).then(() => {
                    console.log('MAMY TO');
                }).catch((e) => {
                    console.error("DUMP");
                });
            }
        }
    }
</script>

<style scoped>

</style>
