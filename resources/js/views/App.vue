<template>
    <v-app dark>
        <v-app-bar
            app
            flat
            hide-on-scroll
            color="transparent"
        >
            <v-icon
                @click="$router.go(-1)"
                v-if="$route.name !== 'dashboard'"
            >mdi-arrow-left</v-icon>
            <v-spacer></v-spacer>
            <v-toolbar-title class="font-m font-weight-bold">{{$route.meta.title ? $route.meta.title : ""}}</v-toolbar-title>
        </v-app-bar>
        <v-dialog
            v-model="menuDialog"
            fullscreen
            transition="dialog-bottom-transition"
            content-class="mt-20"
        >
           <v-card color="navBackground" class="rounded-t-lg">
              <v-container>
                  <h2 class="pl-4">Menu</h2>
                  <v-list
                      flat
                      nav
                      color="transparent"
                  >
                      <v-list-item
                          :ripple="false"
                          :to="{name: menuItem.link}"
                          active-class="primary"
                          @click="menuDialog = !menuDialog"
                          v-for="menuItem in menuItems"
                          :key="menuItem.title"
                      >
                          <v-list-item-icon>
                              <v-icon>{{menuItem.icon}}</v-icon>
                          </v-list-item-icon>
                          <v-list-item-title>{{menuItem.title}}</v-list-item-title>
                      </v-list-item>
                  </v-list>
              </v-container>
           </v-card>
        </v-dialog>
        <v-main>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-main>
        <v-bottom-navigation
            background-color="navBackground"
            class="rounded-t-lg"
            grow
            absolute
            app
            fixed
        >
            <v-btn :to="{name: 'dashboard'}" icon>
                <v-icon>mdi-view-dashboard</v-icon>
            </v-btn>
            <v-btn :to="{name: 'universities'}" icon>
                <v-icon>mdi-school-outline</v-icon>
            </v-btn>
            <v-btn :to="{name: 'companies'}" icon>
                <v-icon>mdi-briefcase-outline</v-icon>
            </v-btn>
            <v-btn icon @click="menuDialog=!menuDialog">
                <v-icon>mdi-dots-horizontal</v-icon>
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
                menuItems: [
                    {
                        link: 'dashboard',
                        icon: 'mdi-view-dashboard',
                        title: 'Dashboard'
                    },
                    {
                        link: 'universities',
                        icon: 'mdi-school-outline',
                        title: 'Uczelnia'
                    },
                    {
                        link: 'companies',
                        icon: 'mdi-briefcase-outline',
                        title: 'Firma'
                    },
                    {
                        link: 'offers',
                        icon: 'mdi-briefcase-outline',
                        title: 'Oferty Praktyk'
                    },
                    {
                        link: 'journal',
                        icon: 'mdi-notebook',
                        title: 'Dziennik Praktyk'
                    },
                ],
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

    .mt-20 {
        margin-top: 20% !important;
    }

    .font-m {
        font-family: 'Montserrat', sans-serif !important;
    }
</style>
