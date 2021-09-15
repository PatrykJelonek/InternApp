<template>
    <v-form class="pa-5">
        <v-row class="mb-1">
            <v-col cols="6">
                <v-text-field
                    v-model="userData.firstName"
                    label="Imię"
                    outlined
                    color="primary"
                    dense
                    hide-details
                    @focusout="isDataChanged"
                    background-color="component-background"
                ></v-text-field>
            </v-col>
            <v-col cols="6">
                <v-text-field
                    v-model="userData.lastName"
                    label="Nazwisko"
                    outlined
                    color="primary"
                    dense
                    hide-details
                    @focusout="isDataChanged"
                    background-color="component-background"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row class="mb-1">
            <v-col>
                <v-text-field
                    v-model="userData.email"
                    label="Email"
                    readonly
                    disabled
                    outlined
                    color="primary"
                    dense
                    hide-details
                    background-color="component-background"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row class="mb-1">
            <v-col>
                <v-text-field
                    v-model="userData.phone"
                    label="Numer kontaktowy"
                    outlined
                    color="primary"
                    dense
                    hide-details
                    @focusout="isDataChanged"
                    background-color="component-background"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" class="d-flex justify-end">
                <v-btn
                    color="primary"
                    outlined
                    :disabled="!dataChanged"
                    @click="submit"
                >Zapisz
                </v-btn>
            </v-col>
        </v-row>
    </v-form>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "PersonalDataFormCard",

    data() {
        return {
            dataChanged: false,
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
            user: 'auth/user',
        }),
    },

    methods: {
        ...mapActions({
            updateUserData: 'auth/updateUserData',
            setSnackbar: 'snackbar/setSnackbar',
        }),

        isDataChanged() {
            this.dataChanged = this.userData.firstName !== this.user.first_name ||
                this.userData.lastName !== this.user.last_name ||
                this.userData.phone !== this.user.phone;
        },

        async submit() {
            await this.updateUserData(this.userData).then(() => {
                this.setSnackbar({message: 'Dane zostały zmienione!', color: 'success'});
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się zmienić danych!', color: 'error'});
            });
        }
    },

    created() {
        this.userData = {
            firstName: this.user.first_name,
            lastName: this.user.last_name,
            email: this.user.email,
            phone: this.user.phone,
        };
    },
}
</script>

<style scoped>

</style>
