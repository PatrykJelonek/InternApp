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
                    class="component-background"
                    no-data-text="Niestety, ta uczelnia nie posiada jeszcze zarejestrowanych studentów."
                    loading-text="Pobieranie listy studentów..."
                    no-results-text="Niestety, ale nie znaleźliśmy wyników które pasowałby do podanych danych"
                    :search="search"
                >
                    <template v-slot:item.full_name="{ item }">
                        {{ item.full_name }}
                    </template>
                    <template v-slot:item.student.semester="{ item }">
                        {{ `${item.student.semester} Semestr`}}
                    </template>
                    <template v-slot:item.student.study_year="{ item }">
                        {{ `${item.student.study_year} Rok`}}
                    </template>
                    <template v-slot:item.student.specialization.name="{ item }">
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
                        <template v-else>
                            {{ item.student.specialization.name }}
                        </template>
                    </template>
                    <template v-slot:item.universities_with_roles.verified="{ item }">
                        <v-chip outlined small class="ml-2" v-if="!item.universities_with_roles.verified">Niezweryfikowany</v-chip>
                        <v-chip outlined small class="ml-2" color="success" v-else>Zweryfikowany</v-chip>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-menu offset-y class="component-background">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <v-icon>mdi-dots-vertical</v-icon>
                                </v-btn>
                            </template>
                            <v-list dense color="component-background" class="cursor-pointer">
                                <v-list-item v-if="!item.universities_with_roles.verified">
                                    <v-list-item-title>
                                        Akceptuj studenta
                                    </v-list-item-title>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-title @click="$router.push({name: 'user', params: {id: item.id}})">
                                        Zobacz profil
                                    </v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
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

    props: ['search'],

    data() {
        return {
            show: true,
            headers: [
                {text: 'Imię i nazwisko', value: 'full_name'},
                {text: 'Indeks', value: 'student.student_index'},
                {text: 'Semestr', value: 'student.semester'},
                {text: 'Rok', value: 'student.study_year'},
                {text: 'Specjalizacja', value: 'student.specialization.name'},
                {text: 'Status', value: 'universities_with_roles.verified'},
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
    .cursor-pointer {
        cursor: pointer;
    }
</style>
