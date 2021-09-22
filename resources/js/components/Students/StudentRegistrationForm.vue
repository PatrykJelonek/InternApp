<template>
    <v-container>
            <v-form>
                <v-row class="d-flex justify-center">
                    <v-col cols="10">
                        <v-stepper v-model="stepper" :alt-labels="true">
                            <v-stepper-header>
                                <v-stepper-step :complete="stepper>1" step="1" color="blue accent-4">Dane Logowania</v-stepper-step>
                                <v-divider></v-divider>
                                <v-stepper-step :complete="stepper>2" step="2" color="blue accent-4">Dane Uczelniane</v-stepper-step>
                            </v-stepper-header>
                            <v-stepper-items>
                                <v-stepper-content step="1">
                                    <validation-observer ref="observerFirst" v-slot="{ validate }">
                                        <v-row class="d-flex justify-center">
                                            <v-col cols="5">
                                                <validation-provider v-slot="{ errors }"  vid="firstName" rules="required">
                                                    <v-text-field
                                                        label="Imię"
                                                        v-model="studentAccount.firstName"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        placeholder="Jan"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </v-col>
                                            <v-col cols="5">
                                                <validation-provider v-slot="{ errors }"  vid="lastName" rules="required">
                                                    <v-text-field
                                                        label="Nazwisko"
                                                        v-model="studentAccount.lastName"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        placeholder="Kowalski"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </v-col>
                                        </v-row>
                                        <v-row class="d-flex justify-center">
                                            <v-col cols="10">
                                                <validation-provider v-slot="{ errors }"  vid="email" rules="required|email">
                                                    <v-text-field
                                                        label="Email"
                                                        type="email"
                                                        v-model="studentAccount.email"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        placeholder="jankowalski@example.com"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </v-col>
                                        </v-row>
                                        <v-row class="d-flex justify-center">
                                            <v-col cols="10">
                                                <validation-provider v-slot="{ errors }"  vid="phone" rules="required|max:11">
                                                    <v-text-field
                                                        label="Numer Telefonu"
                                                        type="tel"
                                                        v-model="studentAccount.phone"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        placeholder="123-456-789"
                                                        v-on:input="phonePattern"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </v-col>
                                        </v-row>
                                        <v-row class="d-flex justify-center">
                                            <v-col cols="10">
                                                <validation-provider v-slot="{ errors }"  vid="password" rules="required|min:6">
                                                    <v-text-field
                                                        label="Hasło"
                                                        v-model="studentAccount.password"
                                                        type="password"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        placeholder="●●●●●●●"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </v-col>
                                        </v-row>
                                        <v-row class="d-flex justify-center">
                                            <v-col cols="10">
                                                <validation-provider v-slot="{ errors }"  vid="passwordRepeat" rules="required_if:password|confirmed:password">
                                                    <v-text-field
                                                        label="Powtórz Hasło"
                                                        v-model="studentAccount.passwordRepeat"
                                                        type="password"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        placeholder="●●●●●●●"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </v-col>
                                        </v-row>
                                        <v-row class="d-flex justify-center">
                                            <v-col cols="10">
                                                <validation-provider v-slot="{ errors }"  vid="acceptedRules" rules="accept_rules:1">
                                                    <v-checkbox
                                                        v-model="studentAccount.acceptedRules"
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
                                        <v-row class="d-flex justify-center">
                                            <v-col cols="10" class="d-flex justify-end">
                                                <v-btn color="blue accent-4" dark large @click="nextStep">Dalej</v-btn>
                                            </v-col>
                                        </v-row>
                                    </validation-observer>
                                </v-stepper-content>
                                <v-stepper-content step="2">
                                    <validation-observer ref="observerSecond" v-slot="{ validate }">
                                        <v-row class="d-flex justify-center">
                                            <v-col cols="10">
                                                <validation-provider v-slot="{ errors }" vid="universityId" rules="required">
                                                    <v-select
                                                        label="Uczelnia"
                                                        v-model="studentAccount.universityId"
                                                        :items="universities"
                                                        item-text="name"
                                                        item-value="id"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        @change="fetchFacultiesByUniversityId(studentAccount.universityId)"
                                                        :error-messages="errors"
                                                        no-data-text="Przykro nam, ale nie ma jeszcze żadnych uczelni w naszym systemie."
                                                        placeholder="Państwowa Wyższa Szkoła Zawodowa w Elblągu"
                                                    ></v-select>
                                                </validation-provider>
                                            </v-col>
                                        </v-row>
                                        <v-row class="d-flex justify-center">
                                            <v-col cols="4">
                                                <validation-provider v-slot="{ errors }"  vid="index" rules="required|min:0|max:10">
                                                    <v-text-field
                                                        label="Indeks"
                                                        v-model="studentAccount.index"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        placeholder="12345"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </v-col>
                                            <v-col cols="3">
                                                <validation-provider v-slot="{ errors }"  vid="semester" rules="required|min_value:0|max_value:8">
                                                    <v-text-field
                                                        label="Semestr"
                                                        v-model="studentAccount.semester"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        placeholder="7"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </v-col>
                                            <v-col cols="3">
                                                <validation-provider v-slot="{ errors }"  vid="year" rules="required|min_value:0|max_value:4">
                                                    <v-text-field
                                                        label="Rok"
                                                        v-model="studentAccount.year"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        placeholder="3"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </v-col>
                                        </v-row>
                                        <v-row class="d-flex justify-center" v-if="studentAccount.universityId">
                                            <v-col cols="10">
                                                <validation-provider v-slot="{ errors }" vid="facultyId" rules="required">
                                                    <v-select
                                                        label="Wydział"
                                                        v-model="facultyId"
                                                        :items="faculties"
                                                        item-text="name"
                                                        item-value="id"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        :error-messages="errors"
                                                        @change="fetchFieldsByFacultyId(facultyId)"
                                                        no-data-text="Przykro nam, ale ta uczelnia nie posiada jeszcze wydziałów."
                                                        placeholder="Informatyka Stosowana"
                                                    ></v-select>
                                                </validation-provider>
                                            </v-col>
                                        </v-row>
                                        <v-row class="d-flex justify-center" v-if="facultyId">
                                            <v-col cols="10">
                                                <validation-provider v-slot="{ errors }" vid="fieldId" rules="required">
                                                    <v-select
                                                        label="Kierunek studiów"
                                                        v-model="fieldId"
                                                        :items="fields"
                                                        item-text="name"
                                                        item-value="id"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        :error-messages="errors"
                                                        @change="fetchSpecializationsByFieldId(fieldId)"
                                                        no-data-text="Przykro nam, ale ten wydział nie ma przypisanych żadnych kierunków w naszym systemie."
                                                        placeholder="Informatyka"
                                                    ></v-select>
                                                </validation-provider>
                                            </v-col>
                                        </v-row>
                                        <v-row class="d-flex justify-center" v-if="fieldId">
                                            <v-col cols="10">
                                                <validation-provider v-slot="{ errors }" vid="specializationId" rules="required">
                                                    <v-select
                                                        label="Specjalność"
                                                        v-model="studentAccount.specializationId"
                                                        :items="specializations"
                                                        item-text="name"
                                                        item-value="id"
                                                        outlined
                                                        dense
                                                        hide-details="auto"
                                                        :error-messages="errors"
                                                        no-data-text="Przykro nam, ale ten kierunek studiów nie ma jeszcze przypisanych specialności!"
                                                        placeholder="Projektowanie Baz Danych"
                                                    ></v-select>
                                                </validation-provider>
                                            </v-col>
                                        </v-row>
                                        <v-row class="d-flex justify-center">
                                            <v-col cols="10" class="d-flex justify-space-between">
                                                <v-btn text large @click="stepper--">Wstecz</v-btn>
                                                <v-btn color="blue accent-4" dark large @click="submit">Rejestruj</v-btn>
                                            </v-col>
                                        </v-row>
                                    </validation-observer>
                                </v-stepper-content>
                            </v-stepper-items>
                        </v-stepper>
                    </v-col>
                </v-row>
            </v-form>
    </v-container>
</template>

<script>
    import {required, email, required_if, confirmed, min, max, min_value, max_value, numeric} from "vee-validate/dist/rules";
    import {  extend, setInteractionMode, ValidationProvider, ValidationObserver } from "vee-validate";
    import {mapActions, mapGetters} from "vuex";

    setInteractionMode('eager');

    export default {
        name: "StudentRegistrationForm",

        components: {
            ValidationProvider,
            ValidationObserver
        },

        data() {
            return {
                stepper: 1,
                studentAccount: {
                    firstName: "",
                    lastName: "",
                    email: "",
                    phone: "",
                    password: "",
                    passwordRepeat: "",
                    acceptedRules: false,
                    universityId: '',
                    index: '',
                    semester: '',
                    year: '',
                    specializationId: ''
                },
                facultyId: '',
                fieldId: '',
            }
        },

        computed: {
            ...mapGetters({
                universities: 'university/universities',
                specializations: 'specialization/specializations',
                faculties: 'faculty/faculties',
                fields: 'field/fields'
            }),
        },

        methods: {
            ...mapActions({
                fetchUniversities: 'university/fetchUniversities',
                fetchSpecializationsByFieldId: 'specialization/fetchSpecializationsByFieldId',
                fetchFacultiesByUniversityId: 'faculty/fetchFacultiesByUniversityId',
                fetchFieldsByFacultyId: 'field/fetchFieldsByFacultyId',
                createStudent: 'student/createStudent'
            }),

            phonePattern() {
                switch(this.studentAccount.phone.length) {
                    case 3:
                    case 7:
                        this.studentAccount.phone += '-';
                }
            },

            nextStep() {
                this.$refs.observerFirst.validate().then((success) => {
                    if(success)
                        this.stepper++;
                });
            },

            submit() {
                this.$refs.observerSecond.validate().then((success) => {
                    if(success) {
                        this.createStudent(this.studentAccount).then(() => {
                            this.$router.replace('/login');
                        }).catch((e) => {
                            if(e.response.status == 422) {
                                this.$refs.observerFirst.setErrors(e.response.data.errors);
                                this.$refs.observerSecond.setErrors(e.response.data.errors);
                            }
                        })
                    }
                });
            }
        },

        created() {
            this.fetchUniversities();
        }
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

    extend('accept_rules', {
        ...min_value,
        message: 'Musisz zaakceptować regulamin!',
    });

    extend('min_value', {
        ...min_value,
        message: 'Wartość musi być większa od {min}!',
    });

    extend('max_value', {
        ...max_value,
        message: 'Wartość nie może przekraczać {max}',
    });

    extend('numeric', {
        ...numeric,
        message: 'Podaj poprawny numer indeksu',
    });
</script>

<style scoped>
    .v-stepper, .v-stepper__header{
        box-shadow: none;
    }
</style>
