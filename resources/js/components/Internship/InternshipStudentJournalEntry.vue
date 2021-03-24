<template>
  <v-list-item>
    <v-list-item-content>
      <v-list-item-title>Dzień {{ getInternshipDay(internshipStartDate, journalEntryDate) }}</v-list-item-title>
      <v-list-item-subtitle>{{ content }}</v-list-item-subtitle>
    </v-list-item-content>
    <v-list-item-content>
      <v-list-item-title class="text-right">{{ formatDate(journalEntryDate, 'DD.MM.YYYY') }}</v-list-item-title>
    </v-list-item-content>
  </v-list-item>
</template>

<script>
import moment from "moment";

export default {
  name: "InternshipStudentJournalEntry",
  props: ['content', 'status', 'internshipStartDate', 'journalEntryDate'],

  methods: {
    getInternshipDay: (internshipStartDate, journalEntryDate) => {
      return moment(journalEntryDate).diff(moment(internshipStartDate), 'days') + 1;
    },

    formatDate(date, format) {
      return moment(date).format(format);
    },
  }
}
</script>

<style scoped>

</style>
