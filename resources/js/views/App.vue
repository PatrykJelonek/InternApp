<template>
    <v-app dark>
        <v-dialog
            v-model="menuDialog"
            fullscreen
            transition="dialog-bottom-transition"
            content-class="mt-10"
        >
           <v-card light>
               <v-card-text>ABC</v-card-text>
           </v-card>
        </v-dialog>
        <v-main>
            <v-container fluid>
                <!--<router-view></router-view>-->
            </v-container>
        </v-main>
        <v-bottom-navigation
            background-color="#181A20"
            active-class="abc"
            class="rounded-t-lg"
            grow
            absolute
            app
            fixed
        >
            <v-btn icon>
                <v-icon>mdi-view-dashboard</v-icon>
            </v-btn>
            <v-btn icon>
                <v-icon>mdi-school-outline</v-icon>
            </v-btn>
            <v-btn icon>
                <v-icon>mdi-briefcase-outline</v-icon>
            </v-btn>
            <v-btn icon @click="menuDialog=!menuDialog">
                <v-icon>mdi-menu</v-icon>
            </v-btn>
        </v-bottom-navigation>
    </v-app>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        data() {
            return {
                menuDialog: false,
                navigationDrawer: {
                    drawer: null,
                    miniVariant: true,
                    group: null,
                }
            }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
        },

        watch: {
            group () {
                this.drawer = false
            },
        },
    }
</script>

<style lang="scss">
    body {
        background-color: #0F1115;
    }

    #app {
        background-color: #0F1115;
        font-family: 'Montserrat', sans-serif;
    }

    .v-expansion-panel-content__wrap {
        padding: 0 !important;
    }

    .hidden {
        opacity: 0;
    }
</style>
