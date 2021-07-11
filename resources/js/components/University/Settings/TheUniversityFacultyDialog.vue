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
                                <v-text-field
                                    v-model="faculty"
                                    label="Nazwa wydziału"
                                    outlined
                                    dense
                                    hide-details="auto"
                                    :error-messages="errors"
                                ></v-text-field>
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
            universityFacultyDialogArgs: 'helpers/universityFacultyDialogArgs',
            faculties: 'faculty/faculties',
            facultiesLoading: 'faculty/facultiesLoading',
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            toggleUniversityFacultyDialog: 'helpers/toggleUniversityFacultyDialog',
            fetchFaculties: 'university/fetchFaculties',
            createUniversityFaculty: 'university/createUniversityFaculty',
            updateUniversityFaculty: 'university/updateUniversityFaculty',
            clearUniversityFacultyDialogArgs: 'helpers/clearUniversityFacultyDialogArgs'
        }),

        async create() {
            await this.createUniversityFaculty({
                slug: this.$route.params.slug, data: {
                    id: null,
                    name: this.faculty,
                }
            }).then(() => {
                this.fetchFaculties(this.$route.params.slug);
                this.setSnackbar({message: 'Instytut został dodany!', color: 'success'});
                this.toggleUniversityFacultyDialog(false);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się dodać instytutu!', color: 'error'});
                this.toggleUniversityFacultyDialog(false);
            });;
        },

        async update() {
            await this.updateUniversityFaculty({
                slug: this.$route.params.slug,
                facultyId: this.universityFacultyDialogArgs.id,
                data: {
                    id: null,
                    name: this.faculty,
                }
            }).then(() => {
                this.fetchFaculties(this.$route.params.slug);
                this.setSnackbar({message: 'Instytut został zaktualizowany!', color: 'success'});
                this.toggleUniversityFacultyDialog(false);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się zaktualizować instytutu!', color: 'error'});
                this.toggleUniversityFacultyDialog(false);
            });
        },

        async submit() {
            if (!this.universityFacultyDialogArgs) {
                await this.create();
            }

            if (this.universityFacultyDialogArgs.action === 'edit') {
                await this.update();
            }
        }
    },

    created() {},

    watch: {
        universityFacultyDialogArgs(newVal, oldVal) {
            if (newVal.action === 'create') {
                this.field = null;
            }

            if (newVal.action === 'edit') {
                this.faculty = newVal.name;
            }
        }
    }
}
</script>

<style scoped>

</style>
