<template>
    <validation-observer ref="observer" v-slot="{ validate, invalid }">
        <v-form>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="name" rules="required|max:64">
                        <v-text-field
                            label="Nazwa frimy"
                            v-model="company.name"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="Intel"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="companyCategoryId" rules="required">
                        <v-select
                            label="Kategoria firmy"
                            v-model="company.companyCategoryId"
                            :items="companyCategories"
                            item-text="name"
                            item-value="id"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            no-data-text="Brak kategorii dla firm!"
                            placeholder="Programowanie"
                        ></v-select>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="8">
                    <validation-provider v-slot="{ errors }" vid="street" rules="required|max:64">
                        <v-text-field
                            label="Ulica"
                            v-model="company.street"
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
                            v-model="company.streetNumber"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="12a/3"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="cityId" rules="required">
                        <v-autocomplete
                            label="Miasto"
                            v-model="company.cityId"
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
            </v-row>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="email" rules="required|email|max:64">
                        <v-text-field
                            label="Email kontakowy"
                            v-model="company.email"
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
                            v-model="company.phone"
                            outlined
                            dense
                            hide-details="auto"
                            prefix="+48"
                            v-mask="'###-###-###'"
                            :error-messages="errors"
                            placeholder="123-456-789"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="website" rules="required|max:64">
                        <v-text-field
                            label="Strona internetowa"
                            v-model="company.website"
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
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="description" rules="required|max:255">
                        <v-textarea
                            v-model="company.description"
                            label="Opis firmy"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="Firma programistyczna"
                        ></v-textarea>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col class="d-flex justify-end">
                    <v-btn color="primary" outlined large @click="submit" :disabled="invalid" class="white--text">Dodaj firmę</v-btn>
                </v-col>
            </v-row>
        </v-form>
    </validation-observer>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import { required, email, max } from "vee-validate/dist/rules";
    import {  extend, setInteractionMode, ValidationProvider, ValidationObserver } from "vee-validate";

    setInteractionMode('eager');

    export default {
        name: "CompanyCreateForm",

        components: {
            ValidationProvider,
            ValidationObserver
        },

        data() {
            return {
                company: {
                    name: null,
                    companyCategoryId: null,
                    cityId: null,
                    street: null,
                    streetNumber: null,
                    email: null,
                    phone: null,
                    website: null,
                    description: null,
                }
            }
        },

        computed: {
            ...mapGetters({
                companyCategories: 'company/companyCategories',
                cities: 'city/cities'
            }),
        },

        methods: {
            ...mapActions({
                updateUserData: 'auth/updateUserData',
                setSnackbar: 'snackbar/setSnackbar',
                fetchCompanyCategories: 'company/fetchCompanyCategories',
                fetchCities: 'city/fetchCities',
                createCompany: 'company/createCompany',
                setSelectedCompany: 'helpers/setSelectedCompany',
                fetchMe: 'auth/me',
            }),

            async submit() {
                this.$refs.observer.validate();

                await this.createCompany(this.company).then((res) => {
                    this.fetchMe();
                    this.$router.push({name: 'company', params: {slug: res.data.slug}});
                    this.setSelectedCompany(res.data);
                    this.setSnackbar({message: 'Firma została dodana!', color: 'success'});
                }).catch((e) => {
                    if(e.response.status === 422) {
                        this.$refs.observer.setErrors(e.response.data.errors);
                    }
                });
            }
        },

        created() {
            this.fetchCompanyCategories();
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
    });
</script>

<style scoped>

</style>
