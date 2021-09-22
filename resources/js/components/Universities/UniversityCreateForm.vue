<template>
    <validation-observer ref="observer" v-slot="{ validate, invalid }">
        <v-form>
            <v-row cols="12">
                <v-col>
                    <validation-provider v-slot="{ errors }"  vid="name" rules="required|max:64">
                        <v-text-field
                            label="Nazwa uczelni"
                            v-model="university.name"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="Politechnika Warszawska"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <validation-provider v-slot="{ errors }" vid="universityTypeId" rules="required">
                        <v-select
                            label="Typ uczelni"
                            v-model="university.universityTypeId"
                            :items="universityTypes"
                            item-text="name"
                            item-value="id"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            no-data-text="Brak typów uczelni!"
                            placeholder="Techniczna"
                        ></v-select>
                    </validation-provider>
                </v-col>
                <v-col cols="8">
                    <validation-provider v-slot="{ errors }" vid="street" rules="required|max:64">
                        <v-text-field
                            label="Ulica"
                            v-model="university.street"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="Wojska Polskiego"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
                <v-col cols="4">
                    <validation-provider v-slot="{ errors }" vid="streetNumber" rules="required|max:8">
                        <v-text-field
                            label="Numer budynku"
                            v-model="university.streetNumber"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="12a/3"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <validation-provider v-slot="{ errors }" vid="cityId" rules="required">
                        <v-autocomplete
                            label="Miasto"
                            v-model="university.cityId"
                            :items="cities"
                            item-text="name"
                            item-value="id"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="Warszawa"
                        ></v-autocomplete>
                    </validation-provider>
                </v-col>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="email" rules="required|email|max:64">
                        <v-text-field
                            label="Email kontakowy"
                            v-model="university.email"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="email@example.com"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="phone" rules="required|max:16">
                        <v-text-field
                            label="Numer kontaktowy"
                            v-model="university.phone"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            prefix="+48"
                            v-mask="'###-###-###'"
                            placeholder="123-456-789"
                        ></v-text-field>
                    </validation-provider>
                </v-col>

                <v-col>
                    <validation-provider v-slot="{ errors }" vid="website" rules="required|max:64">
                        <v-text-field
                            label="Strona internetowa"
                            v-model="university.website"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="www.pw.edu.pl"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col class="d-flex justify-end">
                    <v-btn color="primary" outlined large @click="submit" :disabled="invalid" class="white--text">Dodaj uczelnie</v-btn>
                </v-col>
            </v-row>
        </v-form>
    </validation-observer>
</template>

<script>
    import { mapActions, mapGetters } from "vuex";
    import { required, email, max } from "vee-validate/dist/rules";
    import {  extend, setInteractionMode, ValidationProvider, ValidationObserver } from "vee-validate";

    setInteractionMode('eager');

    export default {
        name: "UniversityCreateForm",

        components: {
            ValidationProvider,
            ValidationObserver
        },

        data() {
            return {
                university: {
                    name: null,
                    universityTypeId: null,
                    cityId: null,
                    street: null,
                    streetNumber: null,
                    email: null,
                    phone: null,
                    website: null,
                }
            }
        },

        computed: {
            ...mapGetters({
                universityTypes: 'university/universityTypes',
                cities: 'city/cities'
            }),
        },

        methods: {
            ...mapActions({
                setSnackbar: 'snackbar/setSnackbar',
                fetchUserUniversities: 'user/fetchUserUniversities',
                fetchUniversityTypes: 'university/fetchUniversityTypes',
                fetchCities: 'city/fetchCities',
                createUniversity: 'university/createUniversity',
                setSelectedUniversity: 'helpers/setSelectedUniversity',
                fetchMe: 'auth/me'
            }),

            async submit(e) {
                this.$refs.observer.validate();

                await this.createUniversity(this.university).then((response) => {
                    this.fetchUserUniversities();
                    this.$router.push({name: 'university', params: {slug: response.slug}});
                    this.setSelectedUniversity(response);
                    this.setSnackbar({message: 'Uczelnia została dodana!', color: 'success'});
                    this.fetchMe();
                }).catch((e) => {
                    if(e.response.status == 422) {
                        this.$refs.observer.setErrors(e.response.data.errors);
                    } else {
                        this.setSnackbar({message: 'Nie udało się dodać uczelni!', color: 'error'});
                    }
                });
            }
        },

        created() {
            this.fetchUniversityTypes();
            this.fetchCities();
        },
    };

    //Rules
    extend('required', {
        ...required,
        message: 'To pole jest wymagane!',
    });

    extend('email', {
       ...email,
       message: "Podaj poprawny adres email!"
    });

    extend('max', {
        ...max,
        message: "Pole nie może przekraczać {length} znaków!"
    })
</script>

<style scoped>

</style>
