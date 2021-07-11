<template>
    <v-dialog
        v-model="universityFieldDialog"
        class="component-background"
        persistent
        max-width="600"
        v-if="universityFieldDialogArgs"
    >
        <custom-card>
            <custom-card-title>
                {{ universityFieldDialogArgs.action === 'create' ? 'Dodaj' : 'Edytuj' }}  kierunek
                <template v-slot:subheader>
                    {{ universityFieldDialogArgs.action === 'create' ? 'Dodaj' : 'Edytuj' }} kierunek
                    {{ universityFieldDialogArgs.action === 'create' ? 'do' : '' }}
                    {{ universityFieldDialogArgs.action === 'create' ? universityFieldDialogArgs.facultyName : universityFieldDialogArgs.name }}
                </template>
                <template v-slot:actions>
                    <v-btn icon small @click="toggleUniversityFieldDialog(false)">
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
                                    v-model="field"
                                    label="Nazwa kierunek"
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
                            <v-btn color="primary" outlined :disabled="field === null" @click="submit">Zapisz</v-btn>
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
import {setInteractionMode, ValidationProvider, ValidationObserver, extend} from "vee-validate";

setInteractionMode('eager');

export default {
    name: "TheUniversityFieldDialog",

    components: {
        CustomCardTitle,
        CustomCard,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            field: null,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            universityFieldDialog: 'helpers/universityFieldDialog',
            universityFieldDialogArgs: 'helpers/universityFieldDialogArgs',
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchFaculties: 'university/fetchFaculties',
            toggleUniversityFieldDialog: 'helpers/toggleUniversityFieldDialog',
            clearUniversityFieldDialogArgs: 'helpers/clearUniversityFieldDialogArgs',
            createUniversityFacultyField: 'university/createUniversityFacultyField',
            updateUniversityFacultyField: 'university/updateUniversityFacultyField',
            setUniversityFieldDialogArgs: 'helpers/setUniversityFieldDialogArgs',
        }),

        async create() {
            await this.createUniversityFacultyField({
                slug: this.$route.params.slug,
                facultyId: this.universityFieldDialogArgs.facultyId,
                data: {
                    name: this.field,
                }
            }).then(() => {
                this.fetchFaculties(this.$route.params.slug);
                this.setSnackbar({message: 'Specjalność została dodana!', color: 'success'});
                this.toggleUniversityFieldDialog(false);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się dodać specjalności!', color: 'error'});
                this.toggleUniversityFieldDialog(false);
            });
        },

        async update() {
            await this.updateUniversityFacultyField({
                slug: this.$route.params.slug,
                facultyId: this.universityFieldDialogArgs.facultyId,
                fieldId: this.universityFieldDialogArgs.id,
                data: {
                    name: this.field,
                }
            }).then(() => {
                this.fetchFaculties(this.$route.params.slug);
                this.setSnackbar({message: 'Specjalność została zaktualizowana!', color: 'success'});
                this.toggleUniversityFieldDialog(false);
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się zaktualizować specjalności!', color: 'error'});
                this.toggleUniversityFieldDialog(false);
            });
        },

        async submit() {
            if (this.universityFieldDialogArgs.action === 'create') {
                await this.create();
            }

            if (this.universityFieldDialogArgs.action === 'edit') {
                await this.update();
            }
        }
    },

    watch: {
        universityFieldDialogArgs(newVal, oldVal) {
            if (newVal.action === 'create') {
                this.field = null;
            }

            if (newVal.action === 'edit') {
                this.field = newVal.name;
            }
        },
    }
}
</script>

<style scoped>

</style>
