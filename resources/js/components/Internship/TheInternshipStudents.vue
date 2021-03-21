<template>
    <v-card elevation="0" color="card-background">
        <v-card-title>Lista studentów</v-card-title>
        <v-card-subtitle>Wybierz jednego ze studentów z poniższej listy by zobaczyć jego wpisy i zadania w dzienniku praktyk.</v-card-subtitle>
        <v-divider></v-divider>
        <v-row>
            <v-col cols="12" class="px-3 pt-8 pb-5">
                <v-slide-group>
                    <v-slide-item class="ml-5">
                        <v-card nav width="250" flat outlined>
                            <v-list dense color="card-background">
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title>Jan Nowak</v-list-item-title>
                                        <v-list-item-subtitle>19745</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-card>
                    </v-slide-item>
                    <v-slide-item class="ml-5">
                        <v-card nav width="250" flat outlined>
                            <v-list dense color="card-background">
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title>Jan Nowak</v-list-item-title>
                                        <v-list-item-subtitle>19745</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-card>
                    </v-slide-item>
                </v-slide-group>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import {mapGetters} from "vuex";
import InternshipStudentListItem from "./InternshipStudentListItem";

export default {
    name: "TheInternshipStudents",
    components: {InternshipStudentListItem},
    data() {
        return {
            show: true,
            btnToggle: undefined
        }
    },

    computed: {
        ...mapGetters({
            internshipStudents: 'internship/internshipStudents'
        })
    },
}
</script>

<style scoped>

</style>
