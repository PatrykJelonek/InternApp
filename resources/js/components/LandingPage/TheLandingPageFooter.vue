<template>
    <v-footer dark class="py-3 px-15" color="blue-grey darken-4">
        <v-container>
            <v-row no-gutters>
                <v-col cols="2" class="pa-0">
                    <v-row class="fill-height" no-gutters>
                        <v-col cols="7" class="d-flex align-self-center mp-2">
                            <h2 class="text-h4">
                                <b>Intern<span class="green--text text--accent-4">App</span></b>
                            </h2>
                        </v-col>
                        <v-col cols="5" class="text-center">
                            <v-divider vertical></v-divider>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="4" class="text-caption">
                    <ul class="footer-list pl-0">
                        <li class="text-overline text-uppercase font-weight-bold grey--text text--accent-3 mb-1">Akcje</li>
                        <li class="mb-2">
                            <router-link class="white--text text-decoration-none text--darken-4" :to="{name: 'login'}">
                                Logowanie
                            </router-link>
                        </li>
                        <li class="mb-2">
                            <router-link class="white--text text-decoration-none text--darken-4"
                                         :to="{name: 'register'}">Rejestracja
                            </router-link>
                        </li>
                        <li class="mb-2">
                            <router-link class="white--text text-decoration-none text--darken-4" :to="{name: 'rules'}">
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
