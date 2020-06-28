<template>
    <v-navigation-drawer
        app
        clipped
        v-model="drawer"
        color="white"
        :expand-on-hover="true"
        :mini-variant="true"
        :permanent="true"
    >
        <v-list dense nav>

            <v-list-item link to="/dashboard" color="blue accent-4" v-if="false">
                <v-list-item-icon>
                    <v-icon>mdi-view-dashboard</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item link to="/universities" color="blue accent-4" v-if="!this.haveRole(['student'])">
                <v-list-item-icon>
                    <v-icon>mdi-school-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Uniwersytety</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item link to="/companies" color="blue accent-4" v-if="!this.haveRole(['student'])">
                <v-list-item-icon>
                    <v-icon>mdi-briefcase-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Firmy</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-group prepend-icon="mdi-newspaper-variant-multiple" no-action color="blue accent-4" v-if="!this.haveRole(['student'])">
                <template v-slot:activator>
                    <v-list-item-title>Oferty</v-list-item-title>
                </template>
                <v-list-item link to="/offers" v-if="!this.haveRole(['student'])">
                    <v-list-item-content>
                        <v-list-item-title>Wszystkie Oferty</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link to="/create-offer" v-if="this.haveRole(['admin', 'company-worker'])">
                    <v-list-item-content>
                        <v-list-item-title>Utwórz Ofertę</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-group>

            <v-list-item link to="/internships" color="blue accent-4" v-if="this.haveRole(['user'])">
                <v-list-item-icon>
                    <v-icon>mdi-newspaper</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Praktyki i Staże</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item link to="/journal" color="blue accent-4" v-if="this.haveRole(['student'])">
                <v-list-item-icon>
                    <v-icon>mdi-notebook-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Dziennik Praktyk</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "DashboardNavigation",

        data() {
            return {
                drawer: true,
            }
        },

        computed: {
            ...mapGetters({
                roles: 'auth/roles',
            })
        },

        methods: {
            haveRole: function (rolesToCheck) {
                let haveRole = false;
                this.roles.forEach((role) => {
                    rolesToCheck.forEach((roleToCheck) => {
                        console.log(`${roleToCheck} vs. ${role} == ${roleToCheck === role}`);
                        if(roleToCheck === role)
                            haveRole = true;
                    });
                });

                return haveRole;
            }
        },
    }
</script>

<style scoped>

</style>
