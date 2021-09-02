<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Informacje podstawowe</template>
            <template v-slot:subheader>Poniżej znajdują się podstawowe informacje na temat tej praktyki.</template>
            <template v-slot:actions>
                <v-btn icon @click="show = !show">
                    <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                </v-btn>
            </template>
        </custom-card-title>
        <v-expand-transition>
            <v-row v-show="show" no-gutters>
                <v-col cols="12" sm="12" md="6" lg="6">
                    <v-list nav dense color="component-background">
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Nazwa:</v-list-item-content>
                            <v-list-item-content>{{ internshipName }}</v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Firma:</v-list-item-content>
                            <v-list-item-content>
                                <router-link :to="{name: 'company', params: {slug: companySlug}}">{{ companyName }}</router-link>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Uczelnia:</v-list-item-content>
                            <v-list-item-content>
                                <router-link :to="{name: 'university', params: {slug: universitySlug}}">{{ universityName }}</router-link>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col cols="12" sm="12" md="6" lg="6">
                    <v-list nav dense color="card-background">
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Okres:</v-list-item-content>
                            <v-list-item-content>{{ getRangeOfInternshipDates(internshipStartDate, internshipEndDate)}}</v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Dzień praktyki:</v-list-item-content>
                            <v-list-item-content>{{ internshipsDaysToToday + ' / ' + allInternshipDays }}</v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Ilość praktykantów:</v-list-item-content>
                            <v-list-item-content>{{ internshipStudents.length }}</v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>
        </v-expand-transition>
    </custom-card>
</template>

<script>
import moment from "moment";
import {mapGetters} from "vuex";
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";

export default {
    name: "TheInternshipInfoCard",
    components: {CustomCardTitle, CustomCard},
    props: ['internshipName', 'internshipStartDate', 'internshipEndDate', 'companySlug', 'companyName', 'universitySlug', 'universityName',],

    data() {
        return {
            percentOfInternship: null,
            allInternshipDays: 0,
            internshipsDaysToToday: 0,
            show: true,
        };
    },

    computed: {
        ...mapGetters({
            internshipLoading: 'internship/internshipLoading',
            internshipStudents: 'internship/internshipStudents'
        })
    },

    methods: {
        getPercentOfInternship(internshipStartDate, internshipEndDate) {
            console.log(moment(internshipStartDate).format('DD.MM.YYYY'));
            this.allInternshipDays = (moment(internshipEndDate).diff(moment(internshipStartDate), 'days')) + 1;
            this.internshipsDaysToToday = (moment().diff(moment(internshipStartDate), 'days')) + 1;

            return Math.round(Math.min(((this.internshipsDaysToToday / this.allInternshipDays) * 100), 100));
        },

        getRangeOfInternshipDates(from, to) {
            const defaultDateFormat = 'DD.MM.YYYY';
            let dateFrom = moment(from);
            let dateTo = moment(to);

            if(dateFrom.format('YYYY') === dateTo.format('YYYY')) {
                return dateFrom.format('DD.MM') + ' - ' + dateTo.format(defaultDateFormat);
            }

            return dateFrom.format(defaultDateFormat) + ' - ' + dateTo.format(defaultDateFormat);
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
