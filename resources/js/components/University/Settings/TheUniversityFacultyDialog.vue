<template>
    <v-dialog
        v-model="universityFacultyDialog"
        class="component-background"
        persistent
        max-width="600"
    >
        <custom-card :loading="facultiesLoading">
            <custom-card-title>
                Dodaj wydział
                <template v-slot:subheader>
                    Dodaj wydział do uczelni {{ university.name }}
                </template>
                <template v-slot:actions>
                    <v-btn icon small @click="toggleUniversityFacultyDialog(false)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>
            <validation-observer ref="observer" v-slot="{ validate }">
                <v-form>
                    <v-row no-gutters class="px-3 py-5">
                        <v-col cols="12">
                            <validation-provider
                                v-slot="{ errors, validate }"
                                vid="name"
                                rules="required"
                            >
                                <v-combobox
                                    v-model="faculty"
                                    :items="faculties"
                                    item-text="name"
                                    item-value="id"
                                    label="Nazwa wydziału"
                                    outlined
                                    dense
                                    hide-details="auto"
                                    :error-messages="errors"
                                ></v-combobox>
                            </validation-provider>
                        </v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col cols="12" class="d-flex justify-end pa-3">
                            <v-btn color="primary" outlined :disabled="faculty === null" @click="submit">Zapisz</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </validation-observer>
        </custom-card>
    </v-dialog>
</template>

<script>
import CustomCard from "../../_General/CustomCard";
import {mapActions, mapGetters} from "vuex";
import CustomCardTitle from "../../_General/CustomCardTitle";
import {setInteractionMode, ValidationProvider, ValidationObserver, extend} from "vee-validate";

setInteractionMode('eager');

export default {
    name: "TheUniversityFacultyDialog",
    components: {
        CustomCardTitle,
        CustomCard,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            faculty: null,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            universityFacultyDialog: 'helpers/universityFacultyDialog',
            faculties: 'faculty/faculties',
            facultiesLoading: 'faculty/facultiesLoading'
        }),
    },

    methods: {
        ...mapActions({
            toggleUniversityFacultyDialog: 'helpers/toggleUniversityFacultyDialog',
            fetchFaculties: 'faculty/fetchFaculties',
            createUniversityFaculty: 'university/createUniversityFaculty'
        }),

        async submit() {
            if (this.faculty.id !== null) {
                await this.createUniversityFaculty({
                    slug: this.$route.params.slug, data: {
                        id: this.faculty.id,
                        name: this.faculty.name,
                    }
                });
            } else {
                await this.createUniversityFaculty({
                    slug: this.$route.params.slug, data: {
                        id: null,
                        name: this.faculty,
                    }
                });
            }
        },
    },

    created() {
        this.fetchFaculties().then((response) => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
