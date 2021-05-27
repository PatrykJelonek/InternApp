<template>
    <v-container>
        <v-row>
            <v-col>
                <custom-card>
                    <v-card-title>
                        <span class="text-h6 font-weight-medium">Ustawienia</span>
                    </v-card-title>

                    <v-divider></v-divider>

                    <div class="pa-5">

                        <v-row>
                            <v-col cols="12">
                                <v-subheader>Dane personalne</v-subheader>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-form>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="userData.firstName"
                                                label="Imię"
                                                outlined
                                                color="primary"
                                                hide-details
                                                background-color="component-background"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="userData.lastName"
                                                label="Nazwisko"
                                                outlined
                                                color="primary"
                                                hide-details
                                                background-color="component-background"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="userData.email"
                                                label="Email"
                                                readonly
                                                disabled
                                                outlined
                                                color="primary"
                                                hide-details
                                                background-color="component-background"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="userData.phone"
                                                label="Numer kontaktowy"
                                                outlined
                                                color="primary"
                                                hide-details
                                                background-color="component-background"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-col>
                        </v-row>
                    </div>
                </custom-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../components/_General/CustomCard";

export default {
    name: "Settings",
    components: {CustomCard},

    data() {
        return {
            userData: {
                firstName: '',
                lastName: '',
                email: '',
                phone: '',
            }
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user'
        })
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Użytkownik', to: {name: 'user', params: {id: this.user.id}}},
            {text: 'Ustawienia', disabled: true}
        ]);

        this.userData = {
            firstName: this.user.first_name,
            lastName: this.user.last_name,
            email: this.user.email,
            phone: this.user.phone,
        }
    }
}
</script>

<style scoped>

</style>
