<template>
    <v-footer dark class="py-3 px-15" color="blue-grey darken-4">
        <v-container>
            <v-row no-gutters>
                <v-col order="2" order-md="1" cols="12" md="3" lg="2" class="pa-0">
                    <v-row class="fill-height" no-gutters>
                        <v-col cols="12" class="hidden-md-and-up mt-8">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col cols="12" md="10" xl="8" class="d-flex align-self-center mp-2" v-bind:class="this.$vuetify.breakpoint.smAndDown ? 'justify-center mt-5' : ''">
                            <h2 class="text-h4">
                                <b>Intern<span class="green--text text--accent-4">App</span></b>
                            </h2>
                        </v-col>
                        <v-col cols="2" class="text-center hidden-sm-and-down">
                            <v-divider vertical></v-divider>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col order="1" order-md="2" cols="12" md="4" class="text-caption">
                    <ul class="footer-list pl-0">
                        <li class="text-overline text-uppercase font-weight-bold mb-2">Akcje
                        </li>
                        <li class="mb-2">
                            <router-link
                                class="grey--text text--lighten-1 text-decoration-none"
                                :to="{name: 'login'}">
                                Logowanie
                            </router-link>
                        </li>
                        <li class="mb-2">
                            <router-link
                                class="grey--text text--lighten-1 text-decoration-none"
                                :to="{name: 'register'}">Rejestracja
                            </router-link>
                        </li>
                        <li class="mb-2">
                            <router-link
                                class="grey--text text--lighten-1 text-decoration-none"
                                :to="{name: 'rules'}">
                                Regulamin
                            </router-link>
                        </li>
                    </ul>
                </v-col>
            </v-row>
        </v-container>
    </v-footer>
</template>

<script>
export default {
    name: "TheLandingPageFooter"
}
</script>

<style lang="scss" scoped>
.footer-list {
    list-style-type: none;
}
</style>
