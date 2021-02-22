<template>
    <v-menu >
        <template v-slot:activator="{ on, attrs }">
            <v-icon v-bind="attrs" v-on="on">mdi-dots-vertical</v-icon>
        </template>
        <v-list dense color="cardBackground">
            <v-list-item dense>
                <v-list-item-content>
                    Pobierz Dziennik
                </v-list-item-content>
            </v-list-item>
            <v-list-item dense>
                <v-list-item-content>
                    Dodaj Opinie
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script>
    import moment from "moment";

    export default {
        name: "InternshipStudentListItemActions",
        props: ['internshipEndDate'],

        methods: {
            isTimeToEvaluateStudent(internshipEndDate) {
                let sevenDaysBeforeToday = moment().subtract(7, 'days');
                let endDate = moment(internshipEndDate);

                return sevenDaysBeforeToday.isAfter(endDate);
            }
        }
    }
</script>

<style scoped>

</style>
