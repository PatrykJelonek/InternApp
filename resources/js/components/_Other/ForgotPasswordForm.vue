<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form>
            <v-row>
                <v-col cols="12">
                    <validation-provider
                        vid="email"
                        v-slot="{ errors }"
                        rules="requiredEmail|email"
                    >
                        <v-text-field
                            dense
                            outlined
                            full-width
                            type="email"
                            label="Email"
                            v-model="email"
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="email@example.com"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" class="d-flex justify-center">
                    <v-btn color="primary" outlined dark @click="submit">Wyślij link</v-btn>
                </v-col>
            </v-row>
        </v-form>
    </validation-observer>
</template>

<script>
import {extend, setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import {mapActions} from "vuex";

setInteractionMode('eager');

export default {
    name: "ForgotPasswordForm",

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            email: null,
        }
    },

    methods: {
        ...mapActions({
            forgotPassword: 'auth/forgotPassword',
            setSnackbar: 'snackbar/setSnackbar'
        }),

        async submit() {
            this.$refs.observer.validate();
            await this.forgotPassword(this.email).then(() => {
                this.setSnackbar({message: 'Link do zresetowania hasła został wysłany!', color: 'success'});
            }).catch((e) => {
                this.setSnackbar({message: 'Nie udało się wysłać linku, skontaktuj się z administracją serwisu!', color: 'error'});
            });
        }
    }
}
</script>

<style scoped>

</style>
