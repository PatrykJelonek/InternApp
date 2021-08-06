<template>
    <v-container fluid class="pa-0">
        <select-type-of-user-dialog :dialog="true"></select-type-of-user-dialog>

        <page-title>
            <template v-slot:default>Uczelnie</template>
            <template v-slot:subheader>Aby dołączyć do uczelni użyj kodu dostępu lub dodaj nową uczelnie.</template>
            <template v-slot:actions>
                <v-btn outlined color="primary" @click="$router.push({name: 'create-university'})">Dodaj Uczelnie
                </v-btn>
            </template>
        </page-title>

        <v-row no-gutters>
            <v-col cols="12">
                <custom-card>
                    <v-text-field hide-details outlined v-model="search" prepend-inner-icon="mdi-magnify"
                                  label="Szukaj"></v-text-field>
                </custom-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <custom-card :loading="universitiesLoading">
                    <custom-card-title>
                        <template v-slot:default>Lista uczelni</template>
                        <template v-slot:subheader>Lista wszystkich uczelni dostępnych w serwisie.</template>
                    </custom-card-title>
                    <v-data-table
                        :headers="headers"
                        :items="universities"
                        :search="search"
                        class="component-background"
                        no-results-text="Ups... Nie udało się znaleźć szukanej uczelni."
                        no-data-text="Ups... Wygląda, że nie mamy jeszcze żadnych uczelni w serwisie!"
                        loading-text="Pobieranie listy uczelni..."
                    >
                        <template v-slot:item.name="{item}">
                            <v-avatar :size="30" rounded class="mr-2" :color="item.logo_url ? '' : 'primary'">
                                <v-img :src="item.logo_url ? '/'+item.logo_url : ''"
                                       :alt="'Logo uczelni ' + item.name"></v-img>
                            </v-avatar>
                            {{ item.name }}
                        </template>
                        <template v-slot:item.join="{item}">
                            <v-btn small outlined color="primary" @click="joinToUniversity(item.slug, item.faculties)" :disabled="!canJoin(item.id)">Dołącz
                            </v-btn>
                        </template>
                    </v-data-table>
                </custom-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import UniversitiesList from "../components/Universities/UniversitiesList";
import PageTitle from "../components/_Helpers/PageTitle";
import CustomCard from "../components/_General/CustomCard";
import CustomCardTitle from "../components/_General/CustomCardTitle";
import SelectTypeOfUserDialog from "../components/Universities/SelectTypeOfUserDialog";

export default {
    name: "Universities",
    props: ['tab'],
    components: {SelectTypeOfUserDialog, CustomCardTitle, CustomCard, PageTitle, UniversitiesList},

    data() {
        return {
            search: '',
            btnLoading: [],
            btnDisabled: [],
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Adres', value: 'full_address'},
                {text: 'Typ', value: 'type.name'},
                {text: 'Dołącz', value: 'join'},
            ]
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            userUniversities: 'user/userUniversities',
            universities: 'university/universities',
            universitiesLoading: 'university/universitiesLoading',
            userUniversitiesLoading: 'user/userUniversitiesLoading',
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchUserUniversities: 'user/fetchUserUniversities',
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            fetchUniversities: 'university/fetchUniversities',
            addWorkerToUniversity: 'university/addWorkerToUniversity',
            setDialogArgs: 'helpers/setDialogArgs',
            toggleDialog: 'helpers/toggleDialog',
        }),

        async joinToUniversity(slug, faculties) {
            this.setDialogArgs({
                key: 'DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER', val: {
                    slug: slug,
                    userId: this.user.id,
                    faculties: faculties
                }
            });
            this.toggleDialog({
                key: 'DIALOG_FIELD_SELECT_TYPE_OF_UNIVERSITY_USER', val: true
            });
        },

        canJoin(id) {
            let userCanJoin = true;

            this.userUniversities.forEach((userUniversities) => {
                if(userUniversities.university.id === id) {
                    userCanJoin = false;
                }
            });

            return userCanJoin;
        }
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Uczelnie', to: {name: 'universities'}, exact: true},
        ]);

        this.fetchUniversities().then((response) => {
            this.fetchUserUniversities().then((response) => {
            }).catch((e) => {
            });
        }).catch((e) => {
        });
    }
}
</script>

<style scoped>

</style>
