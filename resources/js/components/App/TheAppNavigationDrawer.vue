<template>
    <v-navigation-drawer
        app
        dark
        color="#302D48"
        :mini-variant="navigationDrawer"
    >
        <v-list-item class="navigation-logo">
            <v-list-item-content>
                <v-list-item-title class="title">
                    <b>Intern<span class="green--text text--accent-4">App</span></b>
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>

        <v-list nav dense>
            <template v-for="first in items">
                <v-list-item v-if="!first.children" :to="first.to" exact active-class="primary--text">
                    <v-list-item-icon v-if="first.icon">
                        <v-icon dense>{{ first.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>{{ first.text }}</v-list-item-title>
                </v-list-item>
                <v-list-group v-else>
                    <template v-slot:activator>
                        <v-list-item-icon v-if="first.icon">
                            <v-icon dense>{{ first.icon }}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content :to="first.to" exact>
                            <v-list-item-title> {{ first.text }}</v-list-item-title>
                        </v-list-item-content>
                    </template>
                    <template v-for="second in first.children">
                        <v-list-item link v-if="!second.children" :to="second.to" exact>
                            <v-list-item-icon class="mr-2">
                                <v-icon dense>{{ second.icon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>{{ second.text }}</v-list-item-title>
                        </v-list-item>
                        <v-list-group sub-group no-action v-else>
                            <template v-slot:activator>
                                <v-list-item-content :to="second.to" exact>
                                    <v-list-item-title>{{ second.text }}</v-list-item-title>
                                </v-list-item-content>
                            </template>
                            <template v-slot:prependIcon class="mr-2">
                                <v-icon dense class="mr-0">{{ second.icon }}</v-icon>
                            </template>
                            <template v-slot:appendIcon>
                                <v-icon>mdi-chevron-down</v-icon>
                            </template>
                            <v-list-item link :to="third.to" v-if="second.children" v-for="third in second.children"
                                         :key="third.text" exact>
                                <v-list-item-title>{{ third.text }}</v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                    </template>
                </v-list-group>
            </template>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import {mapGetters} from "vuex";

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

    computed: {
        ...mapGetters({
            user: 'auth/user',
            navigationDrawer: 'helpers/navigationDrawer',
            selectedCompany: 'helpers/selectedCompany',
            selectedUniversity: 'helpers/selectedUniversity',
        }),
    },

    watch: {
        $route(to, from) {
            if (to.name.match(/company-*[a-z]*/g)) {
                this.items.forEach((first) => {
                    first.to.params.slug.replaceAll('%company_slug%', this.selectedCompany.slug);
                    first.children.forEach((second) => {
                        second.to.params.slug.replaceAll('%company_slug%', this.selectedCompany.slug);
                        second.children.forEach((third) => {
                            third.to.params.slug.replaceAll('%company_slug%', this.selectedCompany.slug);
                        });
                    });
                });
            }

            if (to.name.match(/university-*[a-z]*/g)) {
                this.items.forEach((first) => {
                    first.to.params.slug.replaceAll('%university_slug%', this.selectedUniversity.slug);
                    first.children.forEach((second) => {
                        second.to.params.slug.replaceAll('%university_slug%', this.selectedUniversity.slug);
                        second.children.forEach((third) => {
                            third.to.params.slug.replaceAll('%university_slug%', this.selectedUniversity.slug);
                        });
                    });
                });
            }
        }
    },

    created() {

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
