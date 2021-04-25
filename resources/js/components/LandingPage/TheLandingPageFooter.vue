<template>
    <v-footer class="py-3 px-15" color="grey lighten-3">
        <v-container>
            <v-row>
                <v-col cols="4" class="text-caption">
                    <ul class="footer-list">
                        <li class="text-overline text--disabled text-uppercase font-weight-bold"   >Akcje</li>
                        <li class="mb-2">
                            <router-link class="grey--text text-decoration-none text--darken-4" :to="{name: 'login'}">Logowanie</router-link>
                        </li>
                        <li class="mb-2">
                            <router-link class="grey--text text-decoration-none text--darken-4" :to="{name: 'register'}">Rejestracja</router-link>
                        </li>
                        <li class="mb-2">
                            <router-link class="grey--text text-decoration-none text--darken-4" :to="{name: 'rules'}">Regulamin</router-link>
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
