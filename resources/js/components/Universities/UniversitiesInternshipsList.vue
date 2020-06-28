<template>
    <v-card outlined>
        <v-data-table
            :headers="headers"
            :items="internships"
            :items-per-page="5"
            :loading="isLoading"
            no-data-text="Nie ma jeszcze żadnych praktyk!"
        >
            <template v-slot:item.student="{ item }">
                {{ item.student.user.first_name + " " + item.student.user.last_name }}
            </template>
            <template v-slot:item.university_supervisor="{ item }">
                {{ item.university_supervisor.first_name + " " + item.university_supervisor.last_name }}
            </template>
            <template v-slot:item.company_supervisor="{ item }">
                {{ item.company_supervisor.first_name + " " + item.company_supervisor.last_name}}
            </template>
            <template v-slot:item.status="{ item }">
                <v-chip :color="item.internship_status_id == 1 ? 'error' : 'success' " dark>
                    {{ item.internship_status_id == 1 ? 'Niepotwierdzony' : 'Potwierdzony'}}
                </v-chip>
            </template>
            <template v-slot:item.action="{ item }">
                <v-menu offset-y left offset-x v-model="actionsMenu" close-on-click :close-on-content-click="false">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-dots-vertical</v-icon>
                        </v-btn>
                    </template>
                    <v-list dense>
                        <v-list-item  v-if="item.internship_status_id == 1" >
                            <v-list-item-title @click="clickToConfirm(item)">Potwierdź</v-list-item-title>
                        </v-list-item>
                        <v-list-group>
                            <template v-slot:activator>
                                <v-list-item-title>Dziennik Praktyk</v-list-item-title>
                            </template>
                            <v-list-item
                                v-for="internship in item.student.internships"
                                :key="internship.id"
                                v-if="internship.agreement.university_id === selectedUniversityId"
                                :to="'/internship/'+internship.id+'/journal'"
                            >
                                <v-list-item-title>{{ internship.offer.name }}</v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                    </v-list>
                </v-menu>
            </template>
        </v-data-table>

        <v-snackbar
            v-model="snackbar"
            :color="snackbarColor"
            right
            bottom
            :timeout="6000"
        >
            {{ snackbarText }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    dark
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                >
                    Zamknij
                </v-btn>
            </template>
        </v-snackbar>
    </v-card>
</template>

<script>
    import {mapGetters, mapActions, mapState} from "vuex";

    export default {
        name: "UniversitiesInternshipsList",

        data() {
            return {
                actionsMenu: false,
                snackbar: false,
                snackbarColor: null,
                snackbarText: '',
                isLoading: true,
                headers: [
                    {text: "Nazwa", value: 'offer.name'},
                    {text: "Student", value: 'student'},
                    {text: "Nr Indeksu", value: 'student.student_index'},
                    {text: "Opiekun z uczelni", value: 'university_supervisor'},
                    {text: "Opiekun z firmy", value: 'company_supervisor'},
                    {text: "Status", value: 'status'},
                    {text: "", value: 'action', align: 'right'},
                ],
            }
        },

        computed: {
            ...mapGetters({
                internships: 'university/internships',
                selectedUniversityId: 'university/selectedUniversityId'
            })
        },

        methods: {
            ...mapActions({
                fetchInternships: 'university/fetchInternships',
                confirm: 'internship/confirm'
            }),

            async clickToConfirm(item) {
                await this.confirm(item.id).then(() => {
                    this.snackbarText = 'Potwierdzono praktykę!';
                    this.snackbarColor = 'success';
                    this.snackbar = true;
                    item.internship_status_id = 2;
                }).catch((e) => {
                    this.snackbarText = 'Przepraszamy, coś poszło nie tak!';
                    this.snackbarColor = 'error';
                    this.snackbar = true;
                })
            },
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
