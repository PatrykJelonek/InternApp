<template>
    <v-dialog
        v-model="createQuestionnaireDialog"
        max-width="800"
        persistent
    >
        <expand-card
            title="Dodaj ankietę"
            :expand="false"
        >
            <template v-slot:buttons>
                <v-btn icon small @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </template>

            <v-form>
                <validation-observer ref="observer" v-slot="{ validate }">
                    <v-row class="pa-5">
                        <v-col cols="12">
                            <validation-provider v-slot="{ errors }" vid="name" rules="required">
                                <v-text-field
                                    hide-details="auto"
                                    outlined
                                    dense
                                    label="Nazwa ankiety"
                                    :error-messages="errors"
                                    v-model="questionnaire.name"
                                ></v-text-field>
                            </validation-provider>
                        </v-col>
                        <v-col cols="12">
                            <validation-provider v-slot="{ errors }" vid="description" rules="required">
                                <v-textarea
                                    hide-details="auto"
                                    outlined
                                    dense
                                    label="Opis ankiety"
                                    :error-messages="errors"
                                    v-model="questionnaire.description"
                                ></v-textarea>
                            </validation-provider>
                        </v-col>
                    </v-row>
                    <v-row class="pa-5 pt-0">
                        <v-col cols="12" class="text-right">
                            <v-btn
                                v-if="originalId || originalName"
                                outlined color="primary"
                                @click="update"
                            >
                                Zapisz
                            </v-btn>
                            <v-btn
                                v-else
                                outlined color="primary"
                                @click="createQuestionnaire"
                            >
                                Dodaj
                            </v-btn>
                        </v-col>
                    </v-row>
                </validation-observer>
            </v-form>
        </expand-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../_Helpers/ExpandCard";
import {extend, setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";

setInteractionMode('eager');

export default {
    name: "CreateQuestionnaireDialog",
    props: ['isCompanyQuestionnaire', 'isUniversityQuestionnaire', 'originalName', 'originalDescription', 'originalId'],
    components: {
        ExpandCard,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            questionnaire: {
                name: null,
                description: null,
            }
        }
    },

    methods: {
        ...mapActions({
            toggleCreateQuestionnaireDialog: 'helpers/toggleCreateQuestionnaireDialog',
            setSnackbar: 'snackbar/setSnackbar',
            createCompanyQuestionnaire: 'questionnaire/createCompanyQuestionnaire',
            createUniversityQuestionnaire: 'questionnaire/createUniversityQuestionnaire',
            addQuestionnaire: 'questionnaire/addQuestionnaire',
            updateQuestionnaire: 'questionnaire/updateQuestionnaire',
        }),

        async createQuestionnaire() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {
                    if (this.isCompanyQuestionnaire) {
                        this.createCompanyQuestionnaire({
                            slug: this.$route.params.slug,
                            questionnaire: this.questionnaire
                        }).then((response) => {
                            this.addQuestionnaire(response.data);
                            this.close();
                            this.setSnackbar({message: 'Ankieta została dodana!', color: 'success'});
                        }).catch((e) => {
                            if (e.response.status === 422) {
                                console.log(e.response.data.errors);
                                this.$refs.observer.setErrors(e.response.data.errors);
                            } else {
                                this.setSnackbar({message: 'Wystąpił problem z dodaniem ankiety!', color: 'error'});
                            }
                        });
                    } else if (this.isUniversityQuestionnaire) {
                        this.createUniversityQuestionnaire({
                            slug: this.$route.params.slug,
                            questionnaire: this.questionnaire
                        }).then((response) => {
                            this.addQuestionnaire(response.data);
                            this.close();
                            this.setSnackbar({message: 'Ankieta została dodana!', color: 'success'});
                        }).catch((e) => {
                            if (e.response.status === 422) {
                                console.log(e.response.data.errors);
                                this.$refs.observer.setErrors(e.response.data.errors);
                            } else {
                                this.setSnackbar({message: 'Wystąpił problem z dodaniem ankiety!', color: 'error'});
                            }
                        });
                    }
                }
            });
        },

        async update() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {
                    this.updateQuestionnaire({
                        id: this.originalId,
                        name: this.questionnaire.name,
                        description: this.questionnaire.description
                    }).then((response) => {
                        this.$store.commit('questionnaire/SET_QUESTIONNAIRE', response.data);
                        this.close();
                        this.setSnackbar({message: 'Ankieta została uaktualniona!', color: 'success'});
                    }).catch((e) => {
                        this.setSnackbar({message: 'Wystąpił problem z edycją ankiety!', color: 'error'});
                    });
                }
            });
        },

        close() {
            this.questionnaire.name = null;
            this.questionnaire.description = null;
            this.toggleCreateQuestionnaireDialog(false);
        }
    },

    computed: {
        ...mapGetters({
            createQuestionnaireDialog: 'helpers/createQuestionnaireDialog',
        }),
    },

    created() {
        if (this.originalName) {
            this.questionnaire.name = this.originalName;
        }

        if (this.originalDescription) {
            this.questionnaire.description = this.originalDescription;
        }
    },
}
</script>

<style scoped>

</style>
