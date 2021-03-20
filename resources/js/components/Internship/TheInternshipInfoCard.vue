<template>
    <v-card elevation="0">
        <v-list>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Informacje podstawowe</v-list-item-title>
                    <v-list-item-subtitle>Ponieżej znajdują się podstawowe informacje na temat tej praktyki.</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn icon @click="show = !show">
                        <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                    </v-btn>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-expand-transition>
            <v-row v-show="show">
                <v-col cols="6">
                    <v-list nav dense>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Nazwa:</v-list-item-content>
                            <v-list-item-content>{{ internshipName }}</v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Firma:</v-list-item-content>
                            <v-list-item-content>
                                <router-link :to="{name: 'company', params: {id: companyId}}">{{ companyName }}</router-link>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Uczelnia:</v-list-item-content>
                            <v-list-item-content>
                                <router-link :to="{name: 'university', params: {id: universityId}}">{{ universityName }}</router-link>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col cols="6">
                    <v-list nav dense>
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
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Status:</v-list-item-content>
                            <v-list-item-content v-if="getPercentOfInternship(internshipStartDate, internshipEndDate) > 99">
                                Zakończone
                            </v-list-item-content>
                            <v-list-item-content v-else>
                                W Trakcie
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
import moment from "moment";
import {mapGetters} from "vuex";

export default {
    name: "TheInternshipInfoCard",
    props: ['internshipName', 'internshipStartDate', 'internshipEndDate', 'companyId', 'companyName', 'universityId', 'universityName',],

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
