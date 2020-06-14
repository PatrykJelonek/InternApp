<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="companyId" rules="required">
                        <v-select
                            label="Firma"
                            v-model="offer.companyId"
                            :items="userCompanies"
                            item-text="name"
                            item-value="id"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            no-data-text="Nie jesteś przypisany do żadnej z firm!"
                            placeholder="Nazwa firmy"
                            :readonly="isReadonly"
                            @change="fetchCompanyUsers(offer.companyId)"
                        ></v-select>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="name" rules="required|max:128">
                        <v-text-field
                            label="Nazwa oferty"
                            v-model="offer.name"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="Staż wakacyjny"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="2">
                    <validation-provider v-slot="{ errors }" vid="placesNumber" rules="required|min_value:1">
                        <v-text-field
                            label="Ilość miejsc"
                            v-model="offer.placesNumber"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="12"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
                <v-col cols="5">
                    <validation-provider v-slot="{ errors }" vid="offerCategoryId" rules="required">
                        <v-select
                            label="Kategoria Oferty"
                            v-model="offer.offerCategoryId"
                            :items="offerCategories"
                            item-text="name"
                            item-value="id"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            no-data-text="Ups... nie dodaliśmy jeszcze kategorii!"
                            placeholder="Kategoria oferty"
                        ></v-select>
                    </validation-provider>
                </v-col>
                <v-col cols="5">
                    <validation-provider v-slot="{ errors }" vid="companySupervisorId" rules="required">
                        <v-select
                            label="Opiekun"
                            v-model="offer.companySupervisorId"
                            :items="companyUsers"
                            item-text="first_name"
                            item-value="id"
                            outlined
                            dense
                            hide-details="auto"
                            :disabled="!offer.companyId"
                            :error-messages="errors"
                            no-data-text="..."
                            placeholder="Opiekun"
                        >
                            <template slot="selection" slot-scope="data">
                                {{ data.item.first_name }} {{ data.item.last_name }}
                            </template>
                            <template slot="item" slot-scope="data">
                                {{ data.item.first_name }} {{ data.item.last_name }}
                            </template>
                        </v-select>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="program" rules="required">
                        <v-textarea
                            label="Program"
                            v-model="offer.program"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="Przykładowy program praktyk/stażu..."
                        ></v-textarea>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="schedule" rules="required">
                        <v-textarea
                            label="Harmonogram"
                            v-model="offer.schedule"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="Przykładowy harmonogram praktyk/stażu..."
                        ></v-textarea>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="offerCategoryId" rules="required">
                        <v-switch
                            class="mt-0"
                            v-model="offer.interview"
                            label="Rozmowa Kwalifikacyjna"
                        ></v-switch>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col class="d-flex justify-end">
                    <v-btn color="blue accent-4" large @click="submit" class="white--text">Dodaj ofertę</v-btn>
                </v-col>
            </v-row>
        </v-form>
    </validation-observer>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import { required, max, min_value, numeric } from "vee-validate/dist/rules";
    import {  extend, setInteractionMode, ValidationProvider, ValidationObserver } from "vee-validate";

    setInteractionMode('eager');

    export default {
        name: "OfferCreateForm",

        components: {
            ValidationProvider,
            ValidationObserver
        },

        data() {
            return {
                offer: {
                    companyId: '',
                    name: '',
                    placesNumber: null,
                    program: '',
                    schedule: '',
                    offerCategoryId: '',
                    companySupervisorId: '',
                    interview: false,
                },
                isReadonly: false,
            }
        },

        computed: {
            ...mapGetters({
                userCompanies: 'user/userCompanies',
                offerCategories: 'offer/offerCategories',
                companyUsers: 'company/companyUsers'
            }),
        },

        methods: {
            ...mapActions({
                fetchUserCompanies: 'user/fetchUserCompanies',
                fetchOfferCategories: 'offer/fetchOfferCategories',
                fetchCompanyUsers: 'company/fetchCompanyUsers',
                createOffer: 'offer/createOffer'
            }),

            async submit() {
                this.$refs.observer.validate();

                await this.createOffer(this.offer).then(() => {
                    this.$router.push('offers');
                }).catch((e) => {
                    // console.log(e.response.data);
                    if(e.response.status == 422) {
                    this.$refs.observer.setErrors(e.response.data.errors);
                    }
                });
            },
        },

        created() {
            this.fetchUserCompanies().then(() => {
                if(this.userCompanies.length === 1) {
                    this.isReadonly = true;
                    this.offer.companyId = this.userCompanies[0].id;
                    this.fetchCompanyUsers(this.userCompanies[0].id);
                }
            });

            this.fetchOfferCategories();
        },

    }

    extend('required', {
        ...required,
        message: 'To pole jest wymagane!',
    });

    extend('max', {
        ...max,
        message: "Pole nie może przekraczać {length} znaków!"
    });

    extend('min_value', {
        ...min_value,
        message: "Wartość musi być liczbą nie mniejszą niż {min}!"
    });

    extend('numeric', {
        ...numeric,
        message: "Wartość musi być liczbą!"
    });
</script>

<style scoped>

</style>
