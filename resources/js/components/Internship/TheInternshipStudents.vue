<template>
    <div>
        <p class="text-h5 font-weight-medium">Lista studentów</p>
        <p class="subtitle-1">Wybierz jednego z poniższych studentów by zobaczyć listę jego wpisów i zadań.</p>
        <v-divider></v-divider>
        <v-row class="mt-5">
            <v-col cols="3">
                <v-card>
                    <v-list dense nav>
                        <v-list-item to="/universities">
                            <v-list-item-content>
                                <v-list-item-title>Jan Nowak</v-list-item-title>
                                <v-list-item-subtitle>18234</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
            <v-col cols="3">
                <v-card>
                    <v-list>
                        <v-list-item to="/universities">
                            <v-list-item-content>
                                <v-list-item-title>Jan Nowak</v-list-item-title>
                                <v-list-item-subtitle>18234</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
            <v-col cols="3">
                <v-card>
                    <v-list>
                        <v-list-item to="/universities">
                            <v-list-item-content>
                                <v-list-item-title>Jan Nowak</v-list-item-title>
                                <v-list-item-subtitle>18234</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
            <v-col cols="3">
                <v-card>
                    <v-list>
                        <v-list-item to="/universities">
                            <v-list-item-content>
                                <v-list-item-title>Jan Nowak</v-list-item-title>
                                <v-list-item-subtitle>18234</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
    </div>

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
