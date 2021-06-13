<template>
    <v-container fluid class="pa-0">
        <v-row>
            <v-col cols="12">
                <v-data-iterator
                    :items="questionnaires"
                    item-key="id"
                    :items-per-page="11"
                >
                    <template v-slot:default="{items}">
                        <v-row>
                            <v-col
                                cols="2"
                                v-for="item in items"
                                :key="item.id"
                            >
                                <custom-card>
                                    <v-container fluid class="pa-5">
                                        <v-card-title>{{item.name}}</v-card-title>
                                    </v-container>
                                </custom-card>
                            </v-col>
                            <v-col cols="2">
                                <custom-card>
                                    <v-container class="d-flex justify-center align-center flex-column pa-5">
                                        <v-icon x-large>mdi-plus</v-icon>
                                        <v-card-text class="text-center">Dodaj Ankietę</v-card-text>
                                    </v-container>
                                </custom-card>
                            </v-col>
                        </v-row>
                    </template>
                </v-data-iterator>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import CustomCard from "../_General/CustomCard";
import VCardHeader from "../_Helpers/VCardHeader";

export default {
    name: "QuestionnairesList",
    components: {VCardHeader, CustomCard},
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
