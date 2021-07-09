<template>
    <custom-card :loading="facultiesLoading && dataLoading">
        <the-university-faculty-dialog></the-university-faculty-dialog>
        <the-university-field-dialog
            :faculty-id="selectedFacultyId"
            :faculty-name="selectedFacultyName"
        ></the-university-field-dialog>
        <the-university-specialization-dialog
            :faculty-id="selectedFacultyId"
            :field-id="selectedFieldId"
            :field-name="selectedFieldName"
        ></the-university-specialization-dialog>
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
            <v-col cols="12">
                <v-treeview :items="facultiesTreeView">
                    <template v-slot:label="{ item }">
                        {{ item.name }}
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

export default {
    name: "TheUniversityFaculties",
    components: {
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
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            faculties: 'university/faculties',
            facultiesTreeView: 'university/facultiesTreeView',
            facultiesLoading: 'university/facultiesLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchFaculties: 'university/fetchFaculties',
            toggleUniversityFieldDialog: 'helpers/toggleUniversityFieldDialog',
            toggleUniversityFacultyDialog: 'helpers/toggleUniversityFacultyDialog',
            toggleUniversitySpecializationDialog: 'helpers/toggleUniversitySpecializationDialog',
            setUniversityFacultyDialogArgs: 'helpers/setUniversityFacultyDialogArgs',
            setUniversityFieldDialogArgs: 'helpers/setUniversityFieldDialogArgs',
            setUniversitySpecializationDialogArgs: 'helpers/setUniversitySpecializationDialogArgs',
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
