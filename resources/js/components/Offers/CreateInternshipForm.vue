<template>
    <v-form class="pa-5">
        <v-row>
            <v-col cols="12">
                <v-stepper v-model="stepper" class="card-background elevation-0">
                    <v-stepper-header class="elevation-0">
                        <v-stepper-step :complete="stepper > 1" step="1" :rules="[() => stepOne]">Miejsce Praktyk</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="stepper > 2" step="2" :rules="[() => stepTwo]">Informacje Podstawowe</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step step="3" :rules="[() => stepThree]">Informacje Dodatkowe</v-stepper-step>
                    </v-stepper-header>

                    <v-stepper-items class="elevation-0">
                        <validation-observer ref="observerStepOne" v-slot="{ validate }">
                            <v-stepper-content step="1">
                                <v-expand-transition>
                                    <v-row v-if="searchCompanyInput && canSearchable" class="mt-1" v>
                                        <v-col cols="12" class="text-center subtitle-1">
                                            Sprawdź czy nie ma już twojej firmy w naszym systemie.
                                        </v-col>
                                        <v-col cols="12">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="companyId"
                                                rules="required_if:companyName"
                                            >
                                                <v-autocomplete
                                                    label="Nazwa Firmy"
                                                    v-model="data.company.id"
                                                    :items="companies"
                                                    item-value="id"
                                                    item-text="name"
                                                    no-data-text="Niestety nie ma takiej firmy w naszym systemie."
                                                    @input="canGoNext = true"
                                                    :loading="companiesLoading"
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-autocomplete>
                                            </validation-provider>
                                        </v-col>
                                    </v-row>
                                </v-expand-transition>
                                <v-row v-if="canSearchable">
                                    <v-col cols="12" class="text-center">
                                        <v-btn
                                            @click="searchCompanyInput = !searchCompanyInput; data.company.id = null; canGoNext = false"
                                            outlined small color="primary"
                                        >
                                            {{
                                                searchCompanyInput ? 'Nie ma mojej firmy na liście' : 'Wyszukaj firmę w serwisie'
                                            }}
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-expand-transition>
                                    <v-row v-if="canGoNext">
                                        <v-col cols="12" class="text-right">
                                            <v-btn color="primary" outlined @click="goNext">
                                                Dalej
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-expand-transition>
                                <v-expand-transition>
                                    <v-row v-if="!searchCompanyInput" class="mt-1">
                                        <v-col cols="7">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="companyName"
                                                rules="required_if:companyId"
                                            >
                                                <v-text-field
                                                    label="Nazwa Firmy"
                                                    v-model="data.company.name"
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="5">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="companyCategoryId"
                                                rules="required_if:companyId"
                                            >
                                                <v-select
                                                    label="Kategoria Firmy"
                                                    v-model="data.company.categoryId"
                                                    :items="companyCategories"
                                                    item-text="name"
                                                    item-value="id"
                                                    :loading="companyCategoriesLoading"
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-select>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="8">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="companyStreet"
                                                rules="required_if:companyId"
                                            >
                                                <v-text-field
                                                    label="Ulica"
                                                    v-model="data.company.street"
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="4">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="companyStreetNumber"
                                                rules="required_if:companyId"
                                            >
                                                <v-text-field
                                                    label="Nr Budynku"
                                                    v-model="data.company.streetNumber"
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="4">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="companyCityPostCode"
                                                rules="required_if:companyId"
                                            >
                                                <v-text-field
                                                    label="Kod Pocztowy"
                                                    v-model="data.company.cityPostCode"
                                                    @focusout="getCity(data.company.cityPostCode)"
                                                    v-on:input="postcodePattern"
                                                    maxlength="6"
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="8">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="companyCityName"
                                                rules="required_if:companyId"
                                            >
                                                <v-text-field
                                                    label="Miasto"
                                                    v-model="data.company.cityName"
                                                    :loading="cityLoading"
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="6">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="companyEmail"
                                                rules="required_if:companyId|email"
                                            >
                                                <v-text-field
                                                    label="Email Firmowy"
                                                    v-model="data.company.email"
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="6">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="companyPhone"
                                                :rules="{ regex: /([0-9]{3}-[0-9]{2,3}-[0-9]{2,9})/ }"
                                            >
                                                <v-text-field
                                                    label="Telefon Firmowy"
                                                    v-model="data.company.phone"
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="12">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="companyWebsite"
                                            >
                                                <v-text-field
                                                    label="Strona Firmowa"
                                                    v-model="data.company.website"
                                                    hint="www.example.com"
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-row>
                                                <v-col cols="12" class="text-right">
                                                    <v-btn outlined color="primary" @click="goNext">
                                                        Dalej
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </v-expand-transition>
                            </v-stepper-content>
                        </validation-observer>
                        <validation-observer ref="observerStepTwo" v-slot="{ validate }">
                            <v-stepper-content step="2">
                                <v-row class="mt-1">
                                    <v-col cols="12">
                                        <validation-provider
                                            v-slot="{ errors }"
                                            vid="offerName"
                                            rules="required"
                                        >
                                            <v-text-field
                                                label="Nazwa Praktyki"
                                                v-model="data.offer.name"
                                                outlined
                                                hide-details="auto"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            v-slot="{ errors }"
                                            vid="offerCategoryId"
                                            rules="required"
                                        >
                                            <v-select
                                                label="Kategoria Praktyk"
                                                v-model="data.offer.categoryId"
                                                :items="offerCategories"
                                                item-text="name"
                                                item-value="id"
                                                :loading="offerCategoriesLoading"
                                                outlined
                                                hide-details="auto"
                                                :error-messages="errors"
                                            ></v-select>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            v-slot="{ errors }"
                                            vid="offerProgram"
                                            rules="required"
                                        >
                                            <v-textarea
                                                label="Program Praktyk"
                                                v-model="data.offer.program"
                                                outlined
                                                hide-details="auto"
                                                :error-messages="errors"
                                            ></v-textarea>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-menu
                                            v-model="dateFromPicker"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <validation-provider
                                                    v-slot="{ errors }"
                                                    vid="agreementDateFrom"
                                                    rules="required"
                                                >
                                                    <v-text-field
                                                        v-model="data.agreement.dateFrom"
                                                        label="Data Rozpoczęcia"
                                                        hide-details="auto"
                                                        :error-messages="errors"
                                                        readonly
                                                        outlined
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </template>
                                            <v-date-picker
                                                :first-day-of-week="0"
                                                locale="pl-pl"
                                                no-title
                                                v-model="data.agreement.dateFrom"
                                                @input="dateFromPicker = false"
                                            ></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-menu
                                            v-model="dateToPicker"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <validation-provider
                                                    v-slot="{ errors }"
                                                    vid="agreementDateTo"
                                                    rules="required"
                                                >
                                                    <v-text-field
                                                        v-model="data.agreement.dateTo"
                                                        label="Data Zakończenia"
                                                        hide-details="auto"
                                                        :error-messages="errors"
                                                        readonly
                                                        outlined
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </template>
                                            <v-date-picker
                                                :first-day-of-week="0"
                                                locale="pl-pl"
                                                no-title
                                                v-model="data.agreement.dateTo"
                                                @input="dateToPicker = false"
                                            ></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                </v-row>
                                <v-row class="mt-1">
                                    <v-col cols="6" class="text-left">
                                        <v-btn color="grey darken-2" outlined @click="stepper--">
                                            Cofnij
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="6" class="text-right">
                                        <v-btn outlined color="primary" @click="goNext">
                                            Dalej
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-stepper-content>
                        </validation-observer>
                        <validation-observer ref="observerStepThree" v-slot="{ validate }">
                            <v-stepper-content step="3">
                                <v-row class="mt-1">
                                    <v-col cols="12">
                                        <v-textarea
                                            label="Harmonogram Praktyk"
                                            v-model="data.offer.schedule"
                                            outlined
                                            hide-details="auto"
                                        ></v-textarea>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            v-slot="{ errors }"
                                            vid="agreementDateFrom"
                                            rules="mimes:pdf"
                                        >
                                            <v-file-input
                                                label="Załącznik"
                                                v-model="data.offer.attachments"
                                                outlined
                                                multiple
                                                show-size
                                                prepend-icon=""
                                            ></v-file-input>
                                        </validation-provider>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="6" class="text-left">
                                        <v-btn outlined @click="stepper--">
                                            Cofnij
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="6" class="text-right">
                                        <v-btn outlined @click="submit">
                                            Wyślij
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-stepper-content>
                        </validation-observer>
                    </v-stepper-items>
                </v-stepper>
            </v-col>
        </v-row>
    </v-form>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";

setInteractionMode('eager');

export default {
    name: "CreateInternshipForm",

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            canGoNext: false,
            canSearchable: true,
            searchCompanyInput: true,
            stepper: 1,
            stepOne: true,
            stepTwo: true,
            stepThree: true,
            dateFromPicker: false,
            dateToPicker: false,
            data: {
                company: {
                    id: '',
                    name: '',
                    street: '',
                    streetNumber: '',
                    cityPostCode: '',
                    cityName: '',
                    cityId: '',
                    email: '',
                    phone: '',
                    website: '',
                    categoryId: '',
                },
                offer: {
                    companyId: '',
                    universityId: '',
                    name: '',
                    program: '',
                    schedule: '',
                    categoryId: '',
                    attachments: ''
                },
                agreement: {
                    dateFrom: '',
                    dateTo: '',
                }
            }
        }
    },

    computed: {
        ...mapGetters({
            companyCategories: 'company/companyCategories',
            companyCategoriesLoading: 'company/companyCategoriesLoading',
            city: 'city/city',
            cityLoading: 'city/cityLoading',
            companies: 'company/companies',
            companiesLoading: 'company/companiesLoading',
            offerCategories: 'offer/offerCategories',
            offerCategoriesLoading: 'offer/offerCategoriesLoading',
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleCreateInternshipDialog',
            fetchCompanyCategories: 'company/fetchCompanyCategories',
            fetchCompanies: 'company/fetchCompanies',
            fetchCity: 'city/fetchCity',
            fetchOfferCategories: 'offer/fetchOfferCategories',
        }),

        submit() {
            this.toggleDialog();
        },

        getCity(postcode) {
            this.fetchCity(postcode).then(() => {
                this.data.company.cityName = this.city.name ?? '';
                this.data.company.cityId = this.city.id ?? '';
            })
        },

        goNext() {
            switch (this.stepper) {
                case 1:
                    this.$refs.observerStepOne.validate().then((value) => {
                        this.stepOne = value;
                        if (value) {
                            this.stepper++
                        }
                    });
                    break;

                case 2:
                    this.$refs.observerStepTwo.validate().then((value) => {
                        this.stepTwo = value;
                        if (value) {
                            this.stepper++
                        }
                    });
                    break;

                case 3:
                    this.$refs.observerStepThree.validate().then((value) => {
                        this.stepThree = value;
                        if (value) {
                            this.stepper++
                        }
                    });
                    break;
            }
        },

        postcodePattern() {
            switch (this.data.company.cityPostCode.length) {
                case 2:
                    this.data.company.cityPostCode += '-';
            }
        },
    },

    created() {
        this.fetchCompanies().then(() => {
            if (this.companies.length < 1) {
                this.canSearchable = false;
                this.searchCompanyInput = false;
            }
        }).catch((e) => {

        });

        this.fetchCompanyCategories().then(() => {

        }).catch((e) => {

        });

        this.fetchOfferCategories().then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
