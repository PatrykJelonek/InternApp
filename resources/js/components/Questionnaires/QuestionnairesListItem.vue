<template>
    <v-card color="transparent" flat>
        <v-row no-gutters>
            <v-col>
                <v-card-title class="text-h6">{{ name }}</v-card-title>
                <v-card-subtitle class="pb-0">{{ description }}</v-card-subtitle>
            </v-col>
            <v-col class="d-flex justify-end align-center">
                <v-btn-toggle borderless dense>
                    <v-btn icon @click="expand = !expand">
                        <v-icon>{{ expand ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                    </v-btn>
                </v-btn-toggle>
            </v-col>
        </v-row>
        <v-expand-transition>
            <v-row v-if="expand" class="grey lighten-3 mb-1 rounded-0 px-3 pt-3">
                <v-col cols="12">
                    <v-row>
                        <v-col cols="12" v-for="(item, index) in questions" :key="item.id">
                            <v-text-field
                                :label="'Pytanie nr '+ (index+1)"
                                dense
                                outlined
                                :value="item.val"
                                hide-details
                                class="d-flex align-center"
                            >
                                <template v-slot:prepend>
                                    <v-btn-toggle dense background-color="transparent">
                                        <v-btn icon @click="goUp(item.pos, index)">
                                            <v-icon>mdi-chevron-up</v-icon>
                                        </v-btn>
                                        <v-btn icon @click="goDown(item.pos, index)">
                                            <v-icon>mdi-chevron-down</v-icon>
                                        </v-btn>
                                    </v-btn-toggle>
                                </template>
                                <template v-slot:append-outer>
                                    <v-icon>mdi-delete-outline</v-icon>
                                </template>
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" class="text-center">
                            <v-tooltip bottom color="tooltip-background">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        icon
                                        dark
                                        color="secondary"
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="addQuestionInput"
                                    >
                                        <v-icon>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                <span>Dodaj pytanie</span>
                            </v-tooltip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" class="text-center">
                            <v-btn small outlined @click="addQuestionInput">
                                Zapisz
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
import CustomCard from "../_General/CustomCard";
import ExpandCard from "../_Helpers/ExpandCard";
import VCardHeader from "../_Helpers/VCardHeader";

export default {
    name: "QuestionnairesListItem",
    components: {VCardHeader, ExpandCard, CustomCard},
    props: ['name', 'description', 'isExpand'],

    data() {
        return {
            questions: [
                {id: 1, val: '1', pos: 1},
                {id: 2, val: '2', pos: 2},
                {id: 3, val: '3', pos: 3},
                {id: 4, val: '4', pos: 4},
            ],
            expand: false,
        }
    },

    methods: {
        addQuestionInput() {
            this.questions.push({id: 5, val: 'daadad', pos: this.questions[this.questions.length - 1].pos + 1});
            this.sortQuestions();
        },

        goUp(pos, key) {
            [this.questions[key].pos, this.questions[key - 1].pos] = [this.questions[key - 1].pos, this.questions[key].pos];
            this.sortQuestions();
        },

        goDown(pos, key) {
            [this.questions[key].pos, this.questions[key + 1].pos] = [this.questions[key + 1].pos, this.questions[key].pos];
            this.sortQuestions();
        },

        sortQuestions() {
            this.questions.sort((a, b) => {
                if (a.pos > b.pos) {
                    return 1;
                }

                if (a.pos < b.pos) {
                    return -1;
                }

                return 0;
            })
        }
    }
}
</script>

<style scoped>

</style>
