<template>
    <v-container>
        <validation-observer ref="observer" v-slot="{ validate }">
            <v-form>
                <v-row>
                    <v-col cols="6">
                        <validation-provider v-slot="{ errors }" vid="firstName" rules="required">
                            <v-text-field
                                label="Imię"
                                v-model="account.firstName"
                                outlined
                                dense
                                hide-details="auto"
                                placeholder="Jan"
                                :error-messages="errors"
                            ></v-text-field>
                        </validation-provider>
                    </v-col>
                    <v-col cols="6">
                        <validation-provider v-slot="{ errors }" vid="lastName" rules="required">
                            <v-text-field
                                label="Nazwisko"
                                v-model="account.lastName"
                                outlined
                                dense
                                hide-details="auto"
                                placeholder="Kowalski"
                                :error-messages="errors"
                            ></v-text-field>
                        </validation-provider>
                    </v-col>
                    <v-col cols="12">
                        <validation-provider v-slot="{ errors }" vid="email" rules="required|email">
                            <v-text-field
                                label="Email"
                                type="email"
                                v-model="account.email"
                                outlined
                                dense
                                hide-details="auto"
                                placeholder="jankowalski@example.com"
                                :error-messages="errors"
                            ></v-text-field>
                        </validation-provider>
                    </v-col>
                    <v-col cols="12">
                        <validation-provider v-slot="{ errors }" vid="phone" rules="required|max:11">
                            <v-text-field
                                label="Numer Telefonu"
                                type="tel"
                                v-model="account.phone"
                                outlined
                                dense
                                hide-details="auto"
                                placeholder="123-456-789"
                                v-on:input="phonePattern"
                                :error-messages="errors"
                            ></v-text-field>
                        </validation-provider>
                    </v-col>
                    <v-col cols="12">
                        <validation-provider v-slot="{ errors }" vid="password" rules="required|min:6">
                            <v-text-field
                                label="Hasło"
                                v-model="account.password"
                                type="password"
                                outlined
                                dense
                                hide-details="auto"
                                placeholder="●●●●●●●"
                                :error-messages="errors"
                            ></v-text-field>
                        </validation-provider>
                    </v-col>
                    <v-col cols="12">
                        <validation-provider v-slot="{ errors }" vid="passwordRepeat"
                                             rules="required_if:password|confirmed:password">
                            <v-text-field
                                label="Powtórz Hasło"
                                v-model="account.passwordRepeat"
                                type="password"
                                outlined
                                dense
                                hide-details="auto"
                                placeholder="●●●●●●●"
                                :error-messages="errors"
                            ></v-text-field>
                        </validation-provider>
                    </v-col>
                    <v-col cols="12">
                        <validation-provider v-slot="{ errors }" vid="acceptedRules" rules="min_value:1">
                            <v-checkbox
                                v-model="account.acceptedRules"
                                color="blue accent-4"
                                class="ma-0"
                                hide-details="auto"
                                :error-messages="errors"
                                :true-value="1"
                                :false-value="0"
                            >
                                <template v-slot:label>
                                    <div>
                                        Przeczytałem i akceptuje
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on }">
                                                <a target="_blank" href="/rules" @click.stop v-on="on">regulamin</a>
                                            </template>
                                            Otwórz w nowym oknie
                                        </v-tooltip>
                                        serwisu.
                                    </div>
                                </template>
                            </v-checkbox>
                        </validation-provider>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="6" class="d-flex justify-start">
                        <v-btn color="secondary" outlined :to="{name: 'login'}">Logowanie</v-btn>
                    </v-col>
                    <v-col cols="6" class="d-flex justify-end">
                        <v-btn color="primary" outlined @click="submitForm">Załóż Konto</v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </validation-observer>
    </v-container>
</template>

<script>
import {mapActions, mapState} from "vuex";
import {required, email, required_if, confirmed, min, min_value, max} from "vee-validate/dist/rules";
import {extend, setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import PageLoader from "./_General/PageLoader";

setInteractionMode('eager');

export default {
    name: "SingUpForm",

    components: {
        PageLoader,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            processed: false,
            account: {
                firstName: "",
                lastName: "",
                email: "",
                phone: "",
                password: "",
                passwordRepeat: "",
                acceptedRules: false
            },
            persistentHint: false,
        }
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            createUserAccount: "user/createUserAccount",
            createUser: "user/createUser",
        }),

        phonePattern() {
            switch (this.account.phone.length) {
                case 3:
                case 7:
                    this.account.phone += '-';
            }
        },

        async submitForm() {
            this.$refs.observer.validate();
            this.processed = true;

            await this.createUser(this.account).then(() => {
                this.account = {
                    firstName: null,
                    lastName: null,
                    email: null,
                    phone: null,
                    password: null,
                    passwordRepeat: null,
                    acceptedRules: false
                };
                this.processed = false;
                this.$router.push({name: 'registration-success'});
                this.setSnackbar({
                    message: 'Twoje konto zostało założone. Aktywuj konto klikając w link wysłany na podany przez Ciebie email.',
                    color: 'success'
                });
            }).catch((e) => {
                this.processed = false;
                if (e.response.status === 422) {
                    this.$refs.observer.setErrors(e.response.data.errors);
                } else {
                    this.setSnackbar({
                        message: 'Wystąpił problem podczas tworzenia konta, skontaktuj się z administratorem serwisu!',
                        color: 'error'
                    });
                }
            });
        }
    },

    computed: {
        ...mapState({
            validationErrors: state => state.user.validationErrors,
        }),
    },
};

extend('required', {
    ...required,
    message: 'To pole jest wymagane!',
});

extend('required_if', {
    ...required_if,
    message: 'Potwierdż hasło!',
});

extend('confirmed', {
    ...confirmed,
    message: 'Hasła muszą być identyczne!',
});

extend('email', {
    ...email,
    message: 'Podaj prawidłowy adres email!',
});

extend('min', {
    ...min,
    message: 'Pole musi mieć min. {length} znaków!',
});

extend('max', {
    ...max,
    message: 'Pole może mieć maks. {length} znaków!',
});

extend('min_value', {
    ...min_value,
    message: 'Musisz zaakceptować regulamin!',
});
</script>

<style scoped>

</style>
