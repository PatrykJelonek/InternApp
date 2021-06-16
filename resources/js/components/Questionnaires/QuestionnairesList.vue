<template>
    <v-container fluid class="pa-0">
        <v-row>
            <v-col cols="12" lg="6">
                <custom-card>
                    <v-container fluid>
                        <v-data-iterator
                            :items="questionnaires"
                            item-key="id"
                            :items-per-page="11"
                        >
                            <template v-slot:default="{items, isExpanded, expand}">
                                <v-row>
                                    <v-col
                                        cols="12"
                                        v-for="item in items"
                                        :key="item.id"
                                    >
                                        <questionnaires-list-item
                                            :name="item.name"
                                            :description="item.description"
                                            :is-expand="isExpanded"
                                        ></questionnaires-list-item>
                                    </v-col>
                                </v-row>
                            </template>
                        </v-data-iterator>
                    </v-container>
                </custom-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import CustomCard from "../_General/CustomCard";
import VCardHeader from "../_Helpers/VCardHeader";
import QuestionnairesListItem from "./QuestionnairesListItem";

export default {
    name: "QuestionnairesList",
    components: {QuestionnairesListItem, VCardHeader, CustomCard},
    props: ['questionnaires'],

    data() {
        return {
            expanded: [],
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Opis', value: 'description'},
                {text: '', value: 'data-table-expand'},
            ],
            questionsHeaders: [
                {text: 'Pytanie', value: 'content'},
                {text: 'Odpowiedzi', value: 'answers'}
            ]
        }
    }
}
</script>

<style lang="scss">
.v-data-table > .v-data-table__wrapper tbody tr.v-data-table__expanded__content {
    box-shadow: none !important;
}
</style>
