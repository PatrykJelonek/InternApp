<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form class="pa-5">
            <v-row class="mb-1">
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="oldPassword"
                        rules="required"
                    >
                        <v-text-field
                            v-model="oldPassword"
                            label="Stare hasło"
                            outlined
                            color="primary"
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            :type="showOldPassword ? 'text' : 'password'"
                            background-color="component-background"
                        >
                            <template v-slot:append-outer>
                                <v-tooltip right color="component-background" :nudge-right="20">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon
                                            v-on="on"
                                            v-bind="attrs"
                                            @click="showOldPassword = !showOldPassword"
                                        >{{ showOldPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline' }}
                                        </v-icon>
                                    </template>
                                    <span>{{ !showOldPassword ? 'Pokaż hasło' : 'Ukryj hasło' }}</span>
                                </v-tooltip>
                            </template>
                        </v-text-field>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row class="mb-1">
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="newPassword"
                        rules="required"
                    >
                        <v-text-field
                            v-model="newPassword"
                            label="Nowe hasło"
                            outlined
                            color="primary"
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            :type="showNewPassword ? 'text' : 'password'"
                            background-color="component-background"
                        >
                            <template v-slot:append-outer>
                                <v-tooltip right color="component-background" :nudge-right="20">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon
                                            v-on="on"
                                            v-bind="attrs"
                                            @click="showNewPassword = !showNewPassword"
                                        >{{ showNewPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline' }}
                                        </v-icon>
                                    </template>
                                    <span>{{ !showNewPassword ? 'Pokaż hasło' : 'Ukryj hasło' }}</span>
                                </v-tooltip>
                            </template>
                        </v-text-field>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row class="mb-1">
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="newPasswordRepeat"
                        rules="required"
                    >
                        <v-text-field
                            v-model="newPasswordRepeat"
                            label="Powtórz hasło"
                            outlined
                            color="primary"
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            :type="showNewPasswordRepeat ? 'text' : 'password'"
                            background-color="component-background"
                        >
                            <template v-slot:append-outer>
                                <v-tooltip right color="component-background" :nudge-right="20">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon
                                            v-on="on"
                                            v-bind="attrs"
                                            @click="showNewPasswordRepeat = !showNewPasswordRepeat"
                                        >{{ showNewPasswordRepeat ? 'mdi-eye-off-outline' : 'mdi-eye-outline' }}
                                        </v-icon>
                                    </template>
                                    <span>{{ !showNewPasswordRepeat ? 'Pokaż hasło' : 'Ukryj hasło' }}</span>
                                </v-tooltip>
                            </template>
                        </v-text-field>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" class="d-flex justify-end">
                    <v-btn
                        color="primary"
                        outlined
                        :disabled="oldPassword.length === 0 || newPassword.length === 0 || newPasswordRepeat.length === 0"
                        @click="submit"
                    >Zapisz
                    </v-btn>
                </v-col>
            </v-row>
        </v-form>
    </validation-observer>
</template>

<script>
import {mapActions} from "vuex";
import {setInteractionMode, ValidationProvider, ValidationObserver, extend} from "vee-validate";

setInteractionMode('eager');

export default {
    name: "ChangeUserPasswordForm",

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            oldPassword: '',
            newPassword: '',
            newPasswordRepeat: '',
            showOldPassword: false,
            showNewPassword: false,
            showNewPasswordRepeat: false,
        }
    },

    methods: {
        ...mapActions({
            updateUserPassword: 'auth/updateUserPassword',
            setSnackbar: 'snackbar/setSnackbar'
        }),

        async submit() {
            this.$refs.observer.validate();
            await this.updateUserPassword({
                oldPassword: this.oldPassword,
                newPassword: this.newPassword,
                newPasswordRepeat: this.newPasswordRepeat
            }).then(() => {
                this.setSnackbar({
                    message: 'Hasło zostało zmienione, za chwile zostaniesz wylogowany!',
                    color: 'success'
                });
                setTimeout(() => {
                    this.$router.push({name: 'logout'});
                }, 3000);
            }).catch((e) => {
                this.$refs.observer.setErrors(e.response.data.errors);
            });
        }
    }
}
</script>

<style scoped>

</style>
