<template>
    <v-navigation-drawer
        app
        color="white"
        clipped
        :mini-variant="navigationDrawer"
    >
        <!--        <v-list-item class="navigation-logo">-->
        <!--            <v-list-item-content>-->
        <!--                <v-list-item-title class="title">-->
        <!--                    <b>Intern<span class="green&#45;&#45;text text&#45;&#45;accent-4">App</span></b>-->
        <!--                </v-list-item-title>-->
        <!--            </v-list-item-content>-->
        <!--        </v-list-item>-->

        <!--        <v-divider></v-divider>-->

        <!-- Navigation -->
        <v-list nav dense>
            <v-list-item :to="{name: 'panel'}" exact active-class="primary--text">
                <v-list-item-icon>
                    <v-icon dense>mdi-chart-bubble</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item>
            <v-list-item :to="{name: 'offers'}" exact active-class="primary--text">
                <v-list-item-icon>
                    <v-icon dense>mdi-newspaper-variant-multiple-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Oferty Praktyk</v-list-item-title>
            </v-list-item>

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
                    <v-list-item link :to="{name: 'university', params: {slug: selectedUniversity.slug}}" exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-view-dashboard-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Informacje</v-list-item-title>
                    </v-list-item>
                    <v-list-item link :to="{name: 'university-agreements', params: {slug: selectedUniversity.slug}}"
                                 exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-file-document-multiple-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Umowy</v-list-item-title>
                    </v-list-item>
                    <v-list-item link :to="{name: 'university-internships', params: {slug: selectedUniversity.slug}}"
                                 exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-certificate-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Praktyki i Staże</v-list-item-title>
                    </v-list-item>
                    <v-list-item link :to="{name: 'university-students', params: {slug: selectedUniversity.slug}}"
                                 exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-account-supervisor</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Studenci</v-list-item-title>
                    </v-list-item>
                    <v-list-item link :to="{name: 'university-workers', params: {slug: selectedUniversity.slug}}" exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-account-multiple-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Pracownicy</v-list-item-title>
                    </v-list-item>
                    <v-list-item link :to="{name: 'university-settings', params: {slug: selectedUniversity.slug}}"
                                 exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-cog</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Ustawienia</v-list-item-title>
                    </v-list-item>
                </template>
                <template v-else>
                    <v-list-item link :to="{name: 'university-create'}" exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-plus</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Dodaj Uczelnie</v-list-item-title>
                    </v-list-item>
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
                    <v-list-item link :to="{name: 'company', params: {slug: selectedCompany.slug}}" exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-view-dashboard-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Informacje</v-list-item-title>
                    </v-list-item>
                    <v-list-item link :to="{name: 'company-offers', params: {slug: selectedCompany.slug}}" exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-newspaper-variant-multiple-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Oferty Praktyk</v-list-item-title>
                    </v-list-item>
                    <v-list-item link :to="{name: 'company-agreements', params: {slug: selectedCompany.slug}}" exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-file-document-multiple-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Umowy</v-list-item-title>
                    </v-list-item>
                    <v-list-item link :to="{name: 'company-workers', params: {slug: selectedCompany.slug}}" exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-account-multiple-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Pracownicy</v-list-item-title>
                    </v-list-item>
                    <v-list-item link :to="{name: 'company-settings', params: {slug: selectedCompany.slug}}" exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-cog</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Ustawienia</v-list-item-title>
                    </v-list-item>
                </template>
                <template v-else>
                    <v-list-item link :to="{name: 'company-create'}" exact>
                        <v-list-item-icon class="mr-2">
                            <v-icon dense>mdi-plus</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Dodaj Firmę</v-list-item-title>
                    </v-list-item>
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
                <v-list-item link :to="{name: 'admin-users'}" exact>
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>mdi-account-group-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Użytkownicy</v-list-item-title>
                </v-list-item>
                <v-list-group sub-group no-action>
                    <template v-slot:activator>
                        <v-list-item-content exact>
                            <v-list-item-title>Oferty Praktyk</v-list-item-title>
                        </v-list-item-content>
                    </template>
                    <template v-slot:prependIcon class="mr-2">
                        <v-icon dense class="mr-0">mdi-newspaper-variant-multiple-outline</v-icon>
                    </template>
                    <template v-slot:appendIcon>
                        <v-icon>mdi-chevron-down</v-icon>
                    </template>
                    <v-list-item link :to="{name: 'admin-offers', query: {categories: ['new']}}" exact>
                        <v-list-item-title>Do Akceptacji</v-list-item-title>
                    </v-list-item>
                    <v-list-item link :to="{name: 'admin-offers'}" exact>
                        <v-list-item-title>Wszystkie</v-list-item-title>
                    </v-list-item>
                </v-list-group>
                <v-list-item link :to="{name: 'admin-settings'}" exact>
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>mdi-cogs</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Ustawienia</v-list-item-title>
                </v-list-item>
            </v-list-group>
        </v-list>

        <!-- Navigation Drawer Append -->
        <template v-slot:append>
            <v-list nav dense>
                <v-list-item link :to="{name: 'admin-settings'}" exact>
                    <v-list-item-icon class="mr-2">
                        <v-icon dense>{{ navigationDrawer ?'mdi-chevron-right' : 'mdi-chevron-left'}}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Zwiń Menu</v-list-item-title>
                </v-list-item>
            </v-list>
        </template>
    </v-navigation-drawer>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "TheAppNavigationDrawer",

    data() {
        return {
            universitySlug: null,
            companySlug: null,
            items: [
                {
                    text: 'Dashboard',
                    icon: 'mdi-chart-bubble',
                    to: {name: 'panel'}
                },
                {
                    text: 'Oferty Praktyk',
                    icon: 'mdi-newspaper-variant-multiple-outline',
                    to: {name: 'offers'}
                },
                {
                    text: 'Uczelnia',
                    icon: 'mdi-school-outline',
                    children: [
                        {
                            text: 'Informacje',
                            icon: 'mdi-view-dashboard-outline',
                            to: {name: 'university', params: {slug: '%university_slug%'}}
                        },
                        {
                            text: 'Umowy',
                            icon: 'mdi-file-document-multiple-outline',
                            to: {name: 'university-agreements', params: {slug: '%university_slug%'}}
                        },
                        {
                            text: 'Praktyki i Staże',
                            icon: 'mdi-certificate-outline',
                            to: {name: 'university-internships', params: {slug: '%university_slug%'}}
                        },
                        {
                            text: 'Studenci',
                            icon: 'mdi-account-supervisor',
                            to: {name: 'university-students', params: {slug: '%university_slug%'}}
                        },
                        {
                            text: 'Pracownicy',
                            icon: 'mdi-account-multiple-outline',
                            to: {name: 'university-workers', params: {slug: '%university_slug%'}}
                        },
                        {
                            text: 'Ustawienia',
                            icon: 'mdi-cog',
                            to: {name: 'university-settings', params: {slug: '%university_slug%'}}
                        },
                    ]
                },
                {
                    text: 'Firma',
                    icon: 'mdi-briefcase-outline',
                    children: [
                        {
                            text: 'Informacje',
                            icon: 'mdi-view-dashboard-outline',
                            to: {name: 'company', params: {slug: '%company_slug%'}}
                        },
                        {
                            text: 'Oferty Praktyk',
                            icon: 'mdi-newspaper-variant-multiple-outline',
                            to: {name: 'company-offers', params: {slug: '%company_slug%'}}
                        },
                        {
                            text: 'Umowy',
                            icon: 'mdi-file-document-multiple-outline',
                            to: {name: 'company-agreements', params: {slug: '%company_slug%'}}
                        },
                        {
                            text: 'Pracownicy',
                            icon: 'mdi-account-multiple-outline',
                            to: {name: 'company-workers', params: {slug: '%company_slug%'}}
                        },
                        {
                            text: 'Ustawienia',
                            icon: 'mdi-cog',
                            to: {name: 'company-settings', params: {slug: '%company_slug%'}}
                        },
                    ]
                },
                {
                    text: 'Panel Administratora',
                    icon: 'mdi-application-cog',
                    children: [
                        {text: 'Dashboard', icon: 'mdi-monitor-dashboard', to: {name: 'admin'}},
                        {text: 'Statystyki', icon: 'mdi-chart-box-outline', to: {name: 'admin-statistics'}},
                        {text: 'Użytkownicy', icon: 'mdi-account-group-outline', to: {name: 'admin-users'}},
                        {
                            text: 'Oferty Praktyk',
                            icon: 'mdi-newspaper-variant-multiple-outline',
                            children: [
                                {text: 'Do Akceptacji', to: {name: 'admin-offers', query: {categories: ['new']}}},
                                {text: 'Wszystkie', to: {name: 'admin-offers'}}
                            ]
                        },
                        {text: 'Ustawienia', icon: 'mdi-cogs', to: {name: 'admin-settings'}},
                    ]
                }
            ]
        }
    },

    methods: {
        ...mapActions({
            setSelectedUniversity: 'helpers/setSelectedUniversity',
            setSelectedCompany: 'helpers/setSelectedCompany'
        })
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            navigationDrawer: 'helpers/navigationDrawer',
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
    display: flex;
    justify-content: left;
    align-items: center;
}
</style>
