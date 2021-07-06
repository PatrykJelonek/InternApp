<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Ustawienia</template>
            <template v-slot:subheader>Ustawienia uczelni {{ university.name }}</template>
        </page-title>
        <v-row>
            <v-col cols="12" md="8" lg="8">
                <the-university-settings-form></the-university-settings-form>
            </v-col>
            <v-col cols="12" md="4" lg="4">
                <the-university-access-code></the-university-access-code>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <the-university-faculties></the-university-faculties>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import TheUniversityFaculties from "./TheUniversityFaculties";
import TheUniversitySettingsForm from "./TheUniversitySettingsForm";
import TheUniversityAccessCode from "./TheUniversityAccessCode";
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../_Helpers/PageTitle";
export default {
    name: "TheUniversitySettings",
    components: {PageTitle, TheUniversityAccessCode, TheUniversitySettingsForm, TheUniversityFaculties},

    computed: {
        ...mapGetters({
            university: 'university/university',
        }),
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Uczelnia', to: {name: 'university', params: {slug: this.$route.params.slug}}, exact: true},
            {text: 'Ustawienia', to: {name: 'university-settings', params: {slug: this.$route.params.slug}}, exact: true},
        ])
    }
}
</script>

<style scoped>

</style>
