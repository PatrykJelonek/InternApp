<template>
    <v-card color="cardBackground">
        <v-card-title>{{ internshipName }}</v-card-title>
        <v-card-subtitle>{{ formatDate(internshipStartDate) }} - {{ formatDate(internshipEndDate) }}</v-card-subtitle>
        <v-progress-linear
            :value="percentOfInternship"
            :indeterminate="percentOfInternship === null"
            :color="percentOfInternship === null ? '#262A34' : percentOfInternship >= 100 ? 'success' : 'primary'"
        ></v-progress-linear>
    </v-card>
</template>

<script>
import moment from "moment";
import {mapGetters} from "vuex";

export default {
    name: "TheInternshipInfoCard",
    props: ['internshipName', 'internshipStartDate', 'internshipEndDate'],

    data() {
        return {
            percentOfInternship: null,
        };
    },

    computed: {
        ...mapGetters({
            internshipLoading: 'internship/internshipLoading',
        })
    },

    methods: {
        getPercentOfInternship(internshipStartDate, internshipEndDate) {
            let allInternshipDays = (moment(internshipEndDate).diff(moment(internshipStartDate), 'days')) + 1;
            let internshipsDaysToToday = (moment().diff(moment(internshipStartDate), 'days')) + 1;

            return Math.round(Math.min(((internshipsDaysToToday / allInternshipDays) * 100), 100));
        },

        formatDate(date, format = 'DD.MM.YYYY') {
            return moment(date).format(format);
        },
    },

    created() {
        this.percentOfInternship = this.getPercentOfInternship(this.internshipStartDate, this.internshipEndDate);
    }
}
</script>

<style scoped>

</style>
