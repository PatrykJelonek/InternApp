<template>
    <v-bottom-navigation color="primary" background-color="component-background" app>
        <v-btn :to="{name: 'panel'}" exact>
            <v-icon>mdi-chart-bubble</v-icon>
        </v-btn>

        <template v-if="user.universities.length > 0">
            <v-btn :to="{name: 'university', params: {slug: selectedUniversity ? selectedUniversity.slug : user.universities[0].slug}}" exact>
                <v-icon>mdi-school-outline</v-icon>
            </v-btn>
        </template>
        <template v-else>
            <v-btn :to="{name: 'universities'}" exact>
                <v-icon>mdi-school-outline</v-icon>
            </v-btn>
        </template>

        <template v-if="user.companies.length > 0">
            <v-btn :to="{name: 'companies', params: {slug: selectedCompany ? selectedCompany.slug : user.companies[0].slug }}" exact>
                <v-icon>mdi-briefcase-outline</v-icon>
            </v-btn>
        </template>
        <template v-else>
            <v-btn :to="{name: 'companies'}" exact>
                <v-icon>mdi-briefcase-outline</v-icon>
            </v-btn>
        </template>

        <v-btn @click="toggleNavigationDrawerModel(!navigationDrawerModel)" v-model="navigationDrawerModel">
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
