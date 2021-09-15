<template>
    <v-navigation-drawer
        app
        floating
        color="component-background"
        :mini-variant="!this.$vuetify.breakpoint.smAndDown && navigationDrawer"
        @input="(val) => toggleNavigationDrawerModel(val)"
        v-model="navigationDrawerModel"
    >
        <div style="height: 64px;" class="primary">
            <v-list nav dense>
                <v-list-item class="mt-1">
                    <v-list-item-icon>
                        <v-icon>mdi-school-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>InternApp</v-list-item-title>
                </v-list-item>
            </v-list>
        </div>

        <!-- Navigation -->
        <v-list nav dense class="mt-5">
            <v-tooltip
                right
                nudge-right="10"
                :open-on-hover="navigationDrawer"
                content-class="tooltip-background"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-list-item
                        exact
                        v-on="on"
                        v-bind="attrs"
                        :to="{name: 'panel'}"
                        active-class="primary--text"
                    >
                        <v-list-item-icon>
                            <v-icon dense>mdi-chart-bubble</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item>
                </template>
                <span>Dashboard</span>
            </v-tooltip>
            <v-tooltip
                right
                nudge-right="10"
                :open-on-hover="navigationDrawer"
                content-class="tooltip-background"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-list-item
                        exact
                        v-on="on"
                        v-bind="attrs"
                        :to="{name: 'offers'}"
                        active-class="primary--text"
                    >
                        <v-list-item-icon>
                            <v-icon dense>mdi-newspaper-variant-multiple-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Oferty Praktyk</v-list-item-title>
                    </v-list-item>
                </template>
                <span>Oferty Praktyk</span>
            </v-tooltip>


            <!-- Uczelnia -->
            <v-list-group active-class="primary--text">
                <template v-slot:activator>
                    <v-list-item-icon>
                        <v-icon dense>mdi-school-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content exact>
                        <v-list-item-title>Uczelnia</v-list-item-title>
                    </v-list-item-content>
                </template>
                <template v-if="user.universities.length > 0">
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'university', params: {slug: selectedUniversity.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-view-dashboard-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Informacje</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Informacje</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'university-agreements', params: {slug: selectedUniversity.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-file-document-multiple-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Umowy</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Umowy</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'university-internships', params: {slug: selectedUniversity.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-certificate-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Praktyki i Staże</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Praktyki i Staże</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'university-students', params: {slug: selectedUniversity.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-account-supervisor</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Studenci</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Studenci</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'university-workers', params: {slug: selectedUniversity.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-account-multiple-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Pracownicy</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Pracownicy</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'university-questionnaires', params: {slug: selectedUniversity.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-comment-question-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Ankiety</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Ankiety</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                        v-if="hasUniversityRole(['university_owner', 'deanery_worker'])"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'university-settings', params: {slug: selectedUniversity.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-cog</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Ustawienia</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Ustawienia</span>
                    </v-tooltip>
                </template>
                <template>
                    <v-divider></v-divider>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'universities'}"
                                class="mt-1"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-plus</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Dodaj Uczelnie</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Dodaj Uczelnie</span>
                    </v-tooltip>
                </template>
            </v-list-group>

            <!-- Firma -->
            <v-list-group active-class="primary--text">
                <template v-slot:activator>
                    <v-list-item-icon>
                        <v-icon dense>mdi-briefcase-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content exact>
                        <v-list-item-title>Firma</v-list-item-title>
                    </v-list-item-content>
                </template>
                <template v-if="user.companies.length > 0">
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'company', params: {slug: selectedCompany.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-view-dashboard-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Informacje</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Informacje</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'company-offers', params: {slug: selectedCompany.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-newspaper-variant-multiple-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Oferty Praktyk</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Oferty Praktyk</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'company-agreements', params: {slug: selectedCompany.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-file-document-multiple-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Umowy</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Umowy</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'company-workers', params: {slug: selectedCompany.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-account-multiple-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Pracownicy</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Pracownicy</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'company-questionnaires', params: {slug: selectedCompany.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-comment-question-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Ankiety</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Ankiety</span>
                    </v-tooltip>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                        v-if="hasCompanyRole(['company_owner', 'company_manager'])"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'company-settings', params: {slug: selectedCompany.slug}}"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-cog</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Ustawienia</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Ustawienia</span>
                    </v-tooltip>
                </template>
                <template>
                    <v-divider></v-divider>
                    <v-tooltip
                        right
                        nudge-right="10"
                        :open-on-hover="navigationDrawer"
                        content-class="tooltip-background"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                link
                                exact
                                v-on="on"
                                v-bind="attrs"
                                :to="{name: 'companies'}"
                                class="mt-1"
                            >
                                <v-list-item-icon class="mr-2">
                                    <v-icon dense>mdi-plus</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Dodaj Firmę</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Dodaj Firmę</span>
                    </v-tooltip>
                </template>
            </v-list-group>

            <!-- Panel Administratora -->
            <v-list-group v-has="['admin']" active-class="primary--text">
                <template v-slot:activator>
                    <v-list-item-icon>
                        <v-icon dense>mdi-application-cog</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content exact>
                        <v-list-item-title>Panel Administratora</v-list-item-title>
                    </v-list-item-content>
                </template>
                <v-list-item link :to="{name: 'admin'}" exact>
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>mdi-monitor-dashboard</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item>
                <v-list-item link :to="{name: 'admin-statistics'}" exact>
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>mdi-chart-box-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Statystyki</v-list-item-title>
                </v-list-item>
                <v-list-item link :to="{name: 'admin-universities'}" exact>
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>mdi-school-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Uczelnie</v-list-item-title>
                </v-list-item>
                <v-list-item link :to="{name: 'admin-companies'}" exact>
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>mdi-briefcase-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Uczelnie</v-list-item-title>
                </v-list-item>
                <v-list-item link :to="{name: 'admin-users'}" exact>
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>mdi-account-group-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Użytkownicy</v-list-item-title>
                </v-list-item>
                <v-list-item link :to="{name: 'admin-offers'}" exact>
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>mdi-newspaper-variant-multiple-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Oferty</v-list-item-title>
                </v-list-item>
                <v-list-item link :to="{name: 'admin-settings'}" exact>
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>mdi-cogs</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Ustawienia</v-list-item-title>
                </v-list-item>
            </v-list-group>
        </v-list>

        <!-- Navigation Drawer Append -->
        <template v-slot:append v-if="!this.$vuetify.breakpoint.smAndDown">
            <v-list nav dense>
                <v-list-item
                    link
                    :to="{name: 'admin-settings'}"
                    exact
                    @click="toggleNavigationDrawer(!navigationDrawer)"
                >
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>{{ navigationDrawer ? 'mdi-chevron-right' : 'mdi-chevron-left' }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Zwiń Menu</v-list-item-title>
                </v-list-item>
            </v-list>
        </template>
    </v-navigation-drawer>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {hasCompanyRole, hasUniversityRole} from "../../plugins/acl";

export default {
    name: "TheAppNavigationDrawer",

    data() {
        return {}
    },

    methods: {
        hasCompanyRole,
        hasUniversityRole,

        ...mapActions({
            setSelectedUniversity: 'helpers/setSelectedUniversity',
            setSelectedCompany: 'helpers/setSelectedCompany',
            toggleNavigationDrawer: 'helpers/toggleNavigationDrawer',
            toggleNavigationDrawerModel: 'helpers/toggleNavigationDrawerModel'
        })
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            navigationDrawer: 'helpers/navigationDrawer',
            navigationDrawerModel: 'helpers/navigationDrawerModel',
            selectedCompany: 'helpers/selectedCompany',
            selectedUniversity: 'helpers/selectedUniversity',
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

<style lang="scss">
.v-application--is-ltr .v-list-item__icon:first-child {
    margin-right: 8px !important;
}

.v-application--is-ltr .v-list--dense .v-list-group--sub-group .v-list-group__header {
    padding-left: 8px !important;
}

.v-list-group--sub-group.v-list-group--active .v-list-item__icon.v-list-group__header__prepend-icon .v-icon {
    transform: none !important;
}

.v-application--is-ltr .v-list--dense.v-list--nav .v-list-group--no-action.v-list-group--sub-group > .v-list-group__items > .v-list-item {
    padding-left: 40px !important;
}

.v-application--is-ltr .v-list-group--sub-group .v-list-item__icon:first-child {
    margin-right: 8px !important;
}

.navigation-logo {
    height: 64px;
}
</style>
