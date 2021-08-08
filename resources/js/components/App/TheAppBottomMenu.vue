<template>
    <v-bottom-navigation color="primary" background-color="component-background">
        <v-btn :to="{name: 'panel'}" exact>
            <span>Dashboard</span>
            <v-icon>mdi-chart-bubble</v-icon>
        </v-btn>

        <v-btn :to="{name: 'offers'}" exact>
            <span>Oferty Praktyk</span>
            <v-icon>mdi-newspaper-variant-multiple-outline</v-icon>
        </v-btn>

        <template v-if="user.universities.length > 0">
            <v-btn :to="{name: 'university', params: {slug: selectedUniversity.slug}}" exact>
                <span>Uczelnia</span>
                <v-icon>mdi-school-outline</v-icon>
            </v-btn>
        </template>
        <template v-else>
            <v-btn :to="{name: 'universities'}" exact>
                <span>Uczelnia</span>
                <v-icon>mdi-school-outline</v-icon>
            </v-btn>
        </template>


        <template v-if="user.companies.length > 0">
            <v-btn :to="{name: 'companies', params: {slug: selectedCompany.slug}}" exact>
                <span>Firma</span>
                <v-icon>mdi-briefcase-outline</v-icon>
            </v-btn>
        </template>
        <template v-else>
            <v-btn :to="{name: 'companies'}" exact>
                <span>Firma</span>
                <v-icon>mdi-briefcase-outline</v-icon>
            </v-btn>
        </template>



        <v-btn @click="toggleNavigationDrawerModel(!navigationDrawerModel)" v-model="navigationDrawerModel">
            <span>Menu</span>
            <v-icon>mdi-menu</v-icon>
        </v-btn>
    </v-bottom-navigation>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "TheAppBottomMenu",

    data() {
        return {
            menuState: false,
        }
    },

    computed: {
      ...mapGetters({
          user: 'auth/user',
          selectedCompany: 'company/selectedCompany',
          selectedUniversity: 'university/selectedUniversity',
          navigationDrawerModel: 'helpers/navigationDrawerModel'
      }),
    },

    methods: {
        ...mapActions({
            toggleNavigationDrawerModel: 'helpers/toggleNavigationDrawerModel'
        }),
    },

    created() {
        if ((this.selectedCompany === undefined || this.selectedCompany === null) && this.user.companies.length > 0) {
            this.setSelectedCompany(this.user.companies[0]);
        }

        if ((this.selectedUniversity === undefined || this.selectedUniversity === null) && this.user.universities.length > 0) {
            this.setSelectedUniversity(this.user.universities[0]);
        }
    },
}
</script>

<style scoped>

</style>
