<template>
    <v-container fluid class="pa-0">
        <create-own-agreement-dialog></create-own-agreement-dialog>
        <page-title>
            <template v-slot:default>Umowy</template>
            <template v-slot:subheader>
                Lista umów przypisanych do {{ university.name }}.
            </template>
            <template v-slot:actions>
                <v-btn color="primary" outlined
                       @click="toggleDialog({key: 'DIALOG_FIELD_CREATE_OWN_AGREEMENT', val: true})">Dodaj umowę
                </v-btn>
            </template>
        </page-title>

        <v-row no-gutters>
            <v-col cols="12">
                <custom-card>
                    <v-text-field
                        v-model="search"
                        outlined
                        prepend-inner-icon="mdi-magnify"
                        label="Szukaj"
                        hide-details
                    ></v-text-field>
                </custom-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <the-university-agreements-list :search="search"></the-university-agreements-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import TheUniversityAgreementsList from "./TheUniversityAgreementsList";
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";
import CreateOwnAgreementDialog from "./CreateOwnAgreementDialog";
import CustomCard from "../../_General/CustomCard";

export default {
    name: "TheUniversityAgreements",
    components: {CustomCard, CreateOwnAgreementDialog, PageTitle, TheUniversityAgreementsList},

    data() {
        return {
            search: null,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university'
        })
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            toggleDialog: 'helpers/toggleDialog',
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {
                text: this.university.name ?? 'Uczelnia',
                to: {name: 'university', params: {slug: this.$route.params.slug}},
                exact: true
            },
            {text: 'Umowy', to: {name: 'university-agreements', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
