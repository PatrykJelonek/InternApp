<template>
    <v-dialog
        v-model="universitySpecializationDialog"
        class="component-background"
        persistent
        max-width="600"
        v-if="universitySpecializationDialogArgs"
    >
        <custom-card>
            <custom-card-title>
                {{ universitySpecializationDialogArgs.action === 'create' ? 'Dodaj' : 'Edytuj' }} specjalność
                <template v-slot:subheader>
                    {{ universitySpecializationDialogArgs.action === 'create' ? 'Dodaj' : 'Edytuj' }} specjalność
                    {{ universitySpecializationDialogArgs.action === 'create' ? 'do' : '' }} kierunku
                    {{ universitySpecializationDialogArgs.fieldName }}
                </template>
                <template v-slot:actions>
                    <v-btn icon small @click="toggleUniversitySpecializationDialog(false)">
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
                                    v-model="specialization"
                                    :value="universitySpecializationDialogArgs.name"
                                    label="Nazwa specjalność"
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
                            <v-btn color="primary" outlined :disabled="specialization === null" @click="submit">Zapisz
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </validation-observer>
        </custom-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import {ValidationObserver, ValidationProvider} from "vee-validate";

export default {
    name: "TheUniversitySpecializationDialog",

    components: {
        CustomCardTitle,
        CustomCard,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            specialization: null,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            universitySpecializationDialog: 'helpers/universitySpecializationDialog',
            universitySpecializationDialogArgs: 'helpers/universitySpecializationDialogArgs',
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchFaculties: 'university/fetchFaculties',
            toggleUniversitySpecializationDialog: 'helpers/toggleUniversitySpecializationDialog',
            createUniversityFacultyFieldSpecialization: 'university/createUniversityFacultyFieldSpecialization',
            updateUniversityFacultyFieldSpecialization: 'university/updateUniversityFacultyFieldSpecialization',
        }),

        clear() {
            this.specialization = null;
        },

        async create() {
            await this.createUniversityFacultyFieldSpecialization({
                slug: this.$route.params.slug,
                facultyId: this.universitySpecializationDialogArgs.facultyId,
                fieldId: this.universitySpecializationDialogArgs.fieldId,
                data: {
                    name: this.specialization,
                }
            }).then(() => {
                this.clear();
                this.fetchFaculties(this.$route.params.slug);
                this.setSnackbar({message: 'Specjalność została dodana!', color: 'success'});
                this.toggleUniversitySpecializationDialog(false);
            }).catch((e) => {
                this.clear();
                this.setSnackbar({message: 'Nie udało się dodać specjalności!', color: 'error'});
                this.toggleUniversitySpecializationDialog(false);
            });
        },

        async update() {
            await this.updateUniversityFacultyFieldSpecialization({
                slug: this.$route.params.slug,
                facultyId: this.universitySpecializationDialogArgs.facultyId,
                fieldId: this.universitySpecializationDialogArgs.fieldId,
                specializationId: this.universitySpecializationDialogArgs.id,
                data: {
                    name: this.specialization,
                }
            }).then(() => {
                this.clear();
                this.fetchFaculties(this.$route.params.slug);
                this.setSnackbar({message: 'Specjalność została zaktualizowana!', color: 'success'});
                this.toggleUniversitySpecializationDialog(false);
            }).catch((e) => {
                this.clear();
                this.setSnackbar({message: 'Nie udało się zaktualizować specjalności!', color: 'error'});
                this.toggleUniversitySpecializationDialog(false);
            });
        },

        async submit() {
            if (this.universitySpecializationDialogArgs.action === 'create') {
                await this.create();
            }

            if (this.universitySpecializationDialogArgs.action === 'edit') {
                await this.update();
            }
        }
    },

    watch: {
        universitySpecializationDialogArgs(newVal, oldVal) {
            if (newVal.action === 'create') {
                this.field = null;
            }

            if (newVal.action === 'edit') {
                this.specialization = newVal.name;
            }
        }
    }
}
</script>

<style scoped>

</style>
