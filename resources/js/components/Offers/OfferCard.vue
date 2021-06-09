<template>
    <custom-card class="mb-5">
        <v-row>
            <v-col>
                <v-row>
                    <v-col cols="12">
                        <v-card-subtitle class="pb-0 d-flex justify-space-between">
                            <span>{{ companyName }}</span>
                            <span>{{ formatCreatedAtDate(createdAt) }}</span>
                        </v-card-subtitle>
                        <v-card-title class="py-0">
                            {{ title }}
                        </v-card-title>
                    </v-col>
                </v-row>
                <v-row class="font-weight-bold text-caption px-4">
                    <v-col cols="auto">
                        <v-icon small>mdi-map-marker</v-icon>
                        {{ city }}
                    </v-col>
                    <v-col cols="auto" v-if="dateFrom || dateTo">
                        <v-icon small>mdi-calendar-range</v-icon>
                        {{ formatDate(dateFrom) + ' - ' + formatDate(dateTo) }}
                    </v-col>
                    <v-col cols="auto" class="error--text" v-if="interview">
                        <v-icon small color="error">mdi-alert-decagram-outline</v-icon>
                        Rozmowa Rekrutacyjna
                    </v-col>
                </v-row>
                <v-row no-gutters dense class="px-4">
                    <v-col cols="12">
                        <v-chip-group>
                            <v-chip x-small outlined color="primary" label>#{{ categoryName }}</v-chip>
                        </v-chip-group>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-card-text class="pt-0">{{ program }}</v-card-text>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import moment from "moment";
import CustomCard from "../_General/CustomCard";
export default {
    name: "OfferCard",
    components: {CustomCard},
    props: ['title', 'companyName', 'createdAt', 'categoryName', 'city', 'interview', 'program', 'dateFrom', 'dateTo'],

    methods: {
        formatCreatedAtDate(date) {
            return moment(date).fromNow();
        },
        formatDate(date) {
            return date ? moment(date).format('DD.MM.YYYY') : '---';
        }
    }
}
</script>

<style scoped>

</style>
