<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Lista studentów</template>
        </custom-card-title>
        <v-row v-show="show" no-gutters>
            <v-col cols="12">
                <v-data-table
                    :headers="headers"
                    :items="students"
                    :items-per-page="5"
                    :loading="studentsLoading"
                    class="elevation-1 component-background"
                >
                    <template v-slot:item.fullname="{ item }">
                        {{ item.first_name + ' ' + item.last_name }}
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-btn icon x-small>
                            <v-icon>mdi-dots-vertical</v-icon>
                        </v-btn>
                    </template>
                    <template v-slot:item.specialization="{ item }">

                        <v-tooltip right color="tooltip-background" v-if="item.student.specialization.deleted_at">
                            <template v-slot:activator="{ on, attrs }">
                                 <span
                                     v-bind="attrs"
                                     v-on="on"
                                     :class="item.student.specialization.deleted_at ? 'text--disabled' : ''"
                                 >{{ item.student.specialization.name }}</span>
                            </template>
                            <span class="text-caption">{{ `Usunięty ${formatDate(item.student.specialization.deleted_at)}` }}</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import moment from "moment";

export default {
    name: "TheUniversityStudentsList",
    components: {CustomCardTitle, CustomCard},
    data() {
        return {
            show: true,
            headers: [
                {text: 'Imię i nazwisko', value: 'fullname'},
                {text: 'Indeks', value: 'student.student_index'},
                {text: 'Semestr', value: 'student.semester'},
                {text: 'Specjalizacja', value: 'specialization'},
                {text: 'Akcje', value: 'actions', sortable: false, align: 'center'},
            ],
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            students: 'university/students',
            studentsLoading: 'university/studentsLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchStudents: 'university/fetchStudents',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        }
    },

    created() {
        this.fetchStudents(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
