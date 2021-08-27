<template>
    <custom-card :loading="facultiesLoading && dataLoading">
        <the-university-faculty-dialog></the-university-faculty-dialog>
        <the-university-field-dialog></the-university-field-dialog>
        <the-university-specialization-dialog></the-university-specialization-dialog>
        <custom-confirm-dialog
            :title="toDelete.title"
            :dialog-state="deleteUniversityFacultyDialog"
            :confirm-function="deleteItem"
            :confirm-function-args="[toDelete.args]"
            :toggle-function="toggleDeleteUniversityFacultyDialog"
        >
            {{ toDelete.description }}
        </custom-confirm-dialog>

        <custom-card-title>
            <template v-slot:default>Wydziały, kierunki i specjalności</template>
            <template v-slot:actions>
                <v-tooltip left color="tooltip-background">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            small
                            v-bind="attrs"
                            v-on="on"
                            @click="toggleUniversityFacultyDialog(true)"
                        >
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                    </template>
                    <span>Dodaj wydział</span>
                </v-tooltip>
            </template>
        </custom-card-title>

        <v-row no-gutters class="pa-1">
            <v-col cols="12" v-if="facultiesTreeView.length > 0">
                <v-treeview :items="facultiesTreeView">
                    <template v-slot:label="{ item }">
                        {{ item.name }}
                        <v-btn-toggle borderless background-color="transparent">
                            <v-tooltip right color="tooltip-background">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        icon
                                        small
                                        class="ml-1"
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="openEditDialog(item)"
                                    >
                                        <v-icon small>mdi-pencil-outline</v-icon>
                                    </v-btn>
                                </template>
                                <span>Edytuj</span>
                            </v-tooltip>
                            <v-tooltip right color="tooltip-background">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        icon
                                        small
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="openDeleteDialog(item)"
                                    >
                                        <v-icon small>mdi-delete</v-icon>
                                    </v-btn>
                                </template>
                                <span>Usuń</span>
                            </v-tooltip>
                        </v-btn-toggle>
                    </template>
                    <template v-slot:append="{ item, open }">
                        <v-tooltip left color="tooltip-background">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    small
                                    v-bind="attrs"
                                    v-on="on"
                                    v-if="item.type !== 'specialization'"
                                    @click="openCreateDialog(item)"
                                >
                                    <v-icon>mdi-plus</v-icon>
                                </v-btn>
                            </template>
                            <span>Dodaj {{ item.type === 'faculty' ? 'Kierunek' : 'Specjalność' }}</span>
                        </v-tooltip>
                    </template>
                </v-treeview>
            </v-col>
            <v-col cols="12" v-else>
                <p class="text--disabled text-center mt-5">Niestety, ta uczelnia nie posiada jeszcze wydziałów!</p>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import TheUniversityFacultyDialog from "./TheUniversityFacultyDialog";
import TheUniversityFieldDialog from "./TheUniversityFieldDialog";
import TheUniversitySpecializationDialog from "./TheUniversitySpecializationDialog";
import CustomConfirmDialog from "../../_General/CustomConfirmDialog";

export default {
    name: "TheUniversityFaculties",
    components: {
        CustomConfirmDialog,
        TheUniversitySpecializationDialog,
        TheUniversityFieldDialog, TheUniversityFacultyDialog, CustomCardTitle, CustomCard
    },

    data() {
        return {
            show: true,
            data: [],
            dataLoading: true,
            selectedFacultyId: null,
            selectedFieldId: null,
            selectedFacultyName: null,
            selectedFieldName: null,
            toDelete: {
                title: null,
                subheader: null,
                description: null,

            }
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            faculties: 'university/faculties',
            facultiesTreeView: 'university/facultiesTreeView',
            facultiesLoading: 'university/facultiesLoading',
            deleteUniversityFacultyDialog: 'helpers/deleteUniversityFacultyDialog'
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchFaculties: 'university/fetchFaculties',
            toggleUniversityFieldDialog: 'helpers/toggleUniversityFieldDialog',
            toggleUniversityFacultyDialog: 'helpers/toggleUniversityFacultyDialog',
            toggleUniversitySpecializationDialog: 'helpers/toggleUniversitySpecializationDialog',
            toggleDeleteUniversityFacultyDialog: 'helpers/toggleDeleteUniversityFacultyDialog',
            setUniversityFacultyDialogArgs: 'helpers/setUniversityFacultyDialogArgs',
            setUniversityFieldDialogArgs: 'helpers/setUniversityFieldDialogArgs',
            setUniversitySpecializationDialogArgs: 'helpers/setUniversitySpecializationDialogArgs',
            deleteUniversityFaculty: 'university/deleteUniversityFaculty',
            deleteUniversityFacultyField: 'university/deleteUniversityFacultyField',
            deleteUniversityFacultyFieldSpecialization: 'university/deleteUniversityFacultyFieldSpecialization',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },

        openCreateDialog(item) {
            switch (item.type) {
                case 'field':
                    this.setUniversitySpecializationDialogArgs({
                        fieldId: item.id,
                        facultyId: item.facultyId,
                        fieldName: item.name,
                        action: 'create',
                    });
                    this.toggleUniversitySpecializationDialog(true);
                    break;
                case 'faculty':
                    this.setUniversityFieldDialogArgs({
                        facultyId: item.id,
                        facultyName: item.name,
                        action: 'create',
                    });
                    this.toggleUniversityFieldDialog(true);
                    break;
            }
        },

        openEditDialog(item) {
            switch (item.type) {
                case 'specialization':
                    this.setUniversitySpecializationDialogArgs({
                        id: item.id,
                        name: item.name,
                        facultyId: item.facultyId,
                        fieldId: item.fieldId,
                        fieldName: item.fieldName,
                        action: 'edit',
                    });
                    this.toggleUniversitySpecializationDialog(true);
                    break;
                case 'field':
                    this.setUniversityFieldDialogArgs({
                        id: item.id,
                        name: item.name,
                        facultyId: item.facultyId,
                        facultyName: item.facultyName,
                        action: 'edit',
                    });
                    this.toggleUniversityFieldDialog(true);
                    break;
                case 'faculty':
                    this.setUniversityFacultyDialogArgs({
                        id: item.id,
                        name: item.name,
                        action: 'edit',
                    });
                    this.toggleUniversityFacultyDialog(true);
                    break;
            }
        },

        openDeleteDialog(item) {
            switch (item.type) {
                case 'specialization':
                    this.toDelete.title = 'Usuń specjalność';
                    this.toDelete.description = `Czy na pewno chcesz specjalność ${item.name}?`
                    break;
                case 'field':
                    this.toDelete.title = 'Usuń kierunek';
                    this.toDelete.description = `Czy na pewno chcesz usunąć kierunek ${item.name}?`
                    break;
                case 'faculty':
                    this.toDelete.title = 'Usuń wydział';
                    this.toDelete.description = `Czy na pewno chcesz usunąć wydział ${item.name}?`
                    break;
            }

            this.toDelete.args = item;
            this.toggleDeleteUniversityFacultyDialog(true);
        },

        async deleteItem(item) {
            switch (item.type) {
                case 'specialization':
                    await this.deleteUniversityFacultyFieldSpecialization({
                        slug: this.$route.params.slug,
                        facultyId: item.facultyId,
                        fieldId: item.fieldId,
                        specializationId: item.id,
                    }).then((response) => {
                        this.setSnackbar({message: 'Specjalność została usunięta!', color: 'success'});
                        this.fetchFaculties(this.$route.params.slug);
                    }).catch((e) => {
                        this.setSnackbar({message: 'Nie udało się usunąć specjalności!', color: 'error'});
                    });
                    break;
                case 'field':
                    await this.deleteUniversityFacultyField({
                        slug: this.$route.params.slug,
                        facultyId: item.facultyId,
                        fieldId: item.id,
                    }).then((response) => {
                        this.setSnackbar({message: 'Kierunek został usunięty!', color: 'success'});
                        this.fetchFaculties(this.$route.params.slug);
                    }).catch((e) => {
                        this.setSnackbar({message: 'Nie udało się usunąć kierunku!', color: 'error'});
                    });
                    break;
                case 'faculty':
                    await this.deleteUniversityFaculty({
                        slug: this.$route.params.slug,
                        facultyId: item.id,
                    }).then((response) => {
                        this.setSnackbar({message: 'Wydział został usunięty!', color: 'success'});
                        this.fetchFaculties(this.$route.params.slug);
                    }).catch((e) => {
                        this.setSnackbar({message: 'Nie udało się usunąć wydziału!', color: 'error'});
                    });
                    break;
            }

            this.toggleDeleteUniversityFacultyDialog(false);
        }
    },

    created() {
        this.dataLoading = true;
        this.fetchFaculties(this.$route.params.slug).then(() => {
            this.dataLoading = false;
        }).catch((e) => {
            console.error(e);
        });
    },
}
</script>

<style scoped>

</style>
