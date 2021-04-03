<template>
    <v-navigation-drawer
        app
        flat
        floating
        clipped
        mini-variant
        expand-on-hover
        width="300px"
        class="component-background"
    >
        <template v-slot:prepend>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon>mdi-account-group</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Lista studentów</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </template>
        <v-list dense>
            <the-internship-students-drawer-item
                v-for="internshipStudent in internshipStudents"
                :key="internshipStudent.id"
                :firstname="internshipStudent.user.first_name"
                :lastname="internshipStudent.user.last_name"
                :index="internshipStudent.student_index"
            ></the-internship-students-drawer-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import router from "../../router/routers";
import TheInternshipStudentsDrawerItem from "./TheInternshipStudentsDrawerItem";

export default {
    name: "TheInternshipStudentsDrawer",
    components: {TheInternshipStudentsDrawerItem},
    props: ['internshipId', 'internshipEndDate'],

    computed: {
        ...mapGetters({
            internshipStudents: 'internship/internshipStudents'
        })
    },

    methods: {
        ...mapActions({
            fetchInternshipStudents: 'internship/fetchInternshipStudents',
        }),

        getRandomHexColor() {
            let r = (Math.floor(Math.random() * 256) + 8).toString(16).toUpperCase();
            let g = (Math.floor(Math.random() * 256) + 8).toString(16).toUpperCase();
            let b = (Math.floor(Math.random() * 256) + 8).toString(16).toUpperCase();

            return '#' + r + g + b;
        },

        cardOnClick(a) {
            router.push({name: 'internship-student', params: {studentIndex: a}});
        },
    },

    created() {
        console.log(this.getRandomHexColor());
        this.fetchInternshipStudents(this.$route.params.internshipId ? this.$route.params.internshipId : this.internshipId).then(() => {

        }).catch((e) => {
            console.error(e);
        });
    }
}
</script>

<style scoped>
</style>
