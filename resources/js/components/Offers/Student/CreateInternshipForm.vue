<template>
    <v-form>
        <v-row v-show="showForm" no-gutters>
            <v-col cols="12">
                <v-stepper v-model="stepper" class="card-background elevation-0" alt-labels>
                    <v-stepper-header class="elevation-0">
                        <v-stepper-step :complete="stepper > 1" step="1" :rules="[() => stepOne]">
                            <span class="text-center">
                                Miejsce Praktyk
                            </span>
                        </v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="stepper > 2" step="2" :rules="[() => stepTwo]">
                            <span class="text-center">
                                Informacje Podstawowe
                            </span>
                        </v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step step="3" :rules="[() => stepThree]">
                            <span class="text-center">
                                Informacje Dodatkowe
                            </span>
                        </v-stepper-step>
                    </v-stepper-header>

                    <v-divider></v-divider>

                    <v-stepper-items class="elevation-0">
                        <validation-observer ref="observerStepOne" v-slot="{ validate }">
                            <v-stepper-content step="1">
                                <v-expand-transition>
                                    <v-row v-if="searchCompanyInput && canSearchable" class="mt-1">
                                        <v-col cols="12" class="text-center subtitle-1">
                                            Sprawdź czy nie ma już twojej firmy w naszym systemie.
                                        </v-col>
                                        <v-col cols="12">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="company.id"
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
                                                    dense
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
                                        <v-col cols="12">
                                            <v-divider></v-divider>
                                        </v-col>
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
                                                vid="company.name"
                                                :rules="data.company.id ? '' : 'required'"
                                            >
                                                <v-text-field
                                                    label="Nazwa Firmy"
                                                    v-model="data.company.name"
                                                    outlined
                                                    dense
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="5">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="company.companyCategoryId"
                                                :rules="data.company.id ? '' : 'required'"
                                            >
                                                <v-select
                                                    label="Kategoria Firmy"
                                                    v-model="data.company.companyCategoryId"
                                                    :items="companyCategories"
                                                    item-text="name"
                                                    item-value="id"
                                                    :loading="companyCategoriesLoading"
                                                    outlined
                                                    dense
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-select>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="8">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="company.street"
                                                :rules="data.company.id ? '' : 'required'"
                                            >
                                                <v-text-field
                                                    label="Ulica"
                                                    v-model="data.company.street"
                                                    outlined
                                                    dense
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="4">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="company.streetNumber"
                                                :rules="data.company.id ? '' : 'required'"
                                            >
                                                <v-text-field
                                                    label="Nr Budynku"
                                                    v-model="data.company.streetNumber"
                                                    outlined
                                                    dense
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="4">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="company.city.postcode"
                                                :rules="data.company.id ? '' : 'required'"
                                            >
                                                <v-text-field
                                                    label="Kod Pocztowy"
                                                    v-model="data.company.city.postcode"
                                                    @focusout="getCity(data.company.city.postcode)"
                                                    v-mask="'##-###'"
                                                    maxlength="6"
                                                    outlined
                                                    dense
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="8">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="company.city.name"
                                                :rules="data.company.id ? '' : 'required'"
                                            >
                                                <v-text-field
                                                    label="Miasto"
                                                    v-model="data.company.city.name"
                                                    :loading="cityLoading"
                                                    outlined
                                                    dense
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="6">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="company.email"
                                                rules="required_if:companyId|email"
                                            >
                                                <v-text-field
                                                    label="Email Firmowy"
                                                    v-model="data.company.email"
                                                    outlined
                                                    dense
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="6">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="company.phone"
                                            >
                                                <v-text-field
                                                    label="Telefon Firmowy"
                                                    v-model="data.company.phone"
                                                    outlined
                                                    dense
                                                    prefix="+48"
                                                    v-mask="'###-###-###'"
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="12">
                                            <validation-provider
                                                v-slot="{ errors }"
                                                vid="company.website"
                                            >
                                                <v-text-field
                                                    label="Strona Firmowa"
                                                    v-model="data.company.website"
                                                    hint="www.example.com"
                                                    outlined
                                                    dense
                                                    hide-details="auto"
                                                    :error-messages="errors"
                                                ></v-text-field>
                                            </validation-provider>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-row>
                                                <v-col cols="12">
                                                    <v-divider></v-divider>
                                                </v-col>
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
                                            vid="agreement.name"
                                            rules="required"
                                        >
                                            <v-text-field
                                                label="Nazwa Praktyki"
                                                v-model="data.agreement.name"
                                                outlined
                                                dense
                                                hide-details="auto"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            v-slot="{ errors }"
                                            vid="agreement.offerCategoryId"
                                            rules="required"
                                        >
                                            <v-select
                                                label="Uczelnia"
                                                v-model="data.agreement.universitySlug"
                                                :items="studentUniversities"
                                                item-text="name"
                                                item-value="slug"
                                                :loading="studentUniversitiesLoading"
                                                outlined
                                                dense
                                                hide-details="auto"
                                                :error-messages="errors"
                                            ></v-select>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            v-slot="{ errors }"
                                            vid="agreement.program"
                                            rules="required"
                                        >
                                            <v-textarea
                                                label="Program Praktyk"
                                                v-model="data.agreement.program"
                                                outlined
                                                dense
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
                                                    vid="agreement.dateFrom"
                                                    rules="required"
                                                >
                                                    <v-text-field
                                                        v-model="data.agreement.dateFrom"
                                                        label="Data Rozpoczęcia"
                                                        hide-details="auto"
                                                        :error-messages="errors"
                                                        readonly
                                                        dense
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
                                                    vid="agreement.dateTo"
                                                    rules="required"
                                                >
                                                    <v-text-field
                                                        v-model="data.agreement.dateTo"
                                                        label="Data Zakończenia"
                                                        hide-details="auto"
                                                        :error-messages="errors"
                                                        readonly
                                                        outlined
                                                        dense
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
                                    <v-col cols="12">
                                        <v-divider></v-divider>
                                    </v-col>
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
                                        <validation-provider
                                            v-slot="{ errors }"
                                            vid="agreement.schedule"
                                        >
                                            <v-textarea
                                                label="Harmonogram Praktyk"
                                                v-model="data.agreement.schedule"
                                                outlined
                                                dense
                                                hide-details="auto"
                                                :error-messages="errors"
                                            ></v-textarea>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            v-slot="{ errors }"
                                            vid="agreement.attachment"
                                        >
                                            <v-file-input
                                                label="Załącznik"
                                                v-model="fileInput"
                                                outlined
                                                show-size
                                                dense
                                                prepend-icon=""
                                                @change="createBase64"
                                                :error-messages="errors"
                                            ></v-file-input>
                                        </validation-provider>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-divider></v-divider>
                                    </v-col>
                                    <v-col cols="6" class="text-left">
                                        <v-btn outlined @click="stepper--">
                                            Cofnij
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="6" class="text-right">
                                        <v-btn outlined @click="submit" color="primary">
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

        <v-row v-show="!showForm">
            <v-fade-transition>
                <v-col v-if="showLoadingCircle" cols="12" class="text-center">
                    <v-progress-circular
                        indeterminate
                        size="100"
                        width="8"
                        color="primary"
                        class="ma-10"
                    ></v-progress-circular>
                </v-col>
            </v-fade-transition>
            <v-fade-transition>
                <v-col v-if="!showLoadingCircle" cols="12" class="text-center">
                    <h3 class="error--text">Coś poszło nie tak!</h3>
                </v-col>
            </v-fade-transition>
        </v-row>
    </v-form>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import {Base64} from 'js-base64';

setInteractionMode('eager');

export default {
    name: "CreateInternshipForm",

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            showForm: true,
            showLoadingCircle: true,
            showErrorMessageTimeout: null,
            canGoNext: false,
            canSearchable: true,
            searchCompanyInput: true,
            stepper: 1,
            stepOne: true,
            stepTwo: true,
            stepThree: true,
            dateFromPicker: false,
            dateToPicker: false,
            fileInput: null,
            data: {
                company: {
                    id: null,
                    name: null,
                    street: null,
                    streetNumber: null,
                    city: {
                        id: null,
                        name: null,
                        postcode: null,
                    },
                    email: null,
                    phone: null,
                    website: null,
                    companyCategoryId: null,
                },
                agreement: {
                    companyId: null,
                    universitySlug: null,
                    name: null,
                    program: null,
                    schedule: null,
                    offerCategoryId: null,
                    dateFrom: null,
                    dateTo: null,
                    attachment: {
                        content: null,
                        name: null,
                        mime: null,
                    },
                },
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
            studentUniversities: 'student/studentUniversities',
            studentUniversitiesLoading: 'student/studentUniversitiesLoading',
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleCreateInternshipDialog',
            setSnackbar: 'snackbar/setSnackbar',
            fetchCompanyCategories: 'company/fetchCompanyCategories',
            fetchCompanies: 'company/fetchCompanies',
            fetchCity: 'city/fetchCity',
            fetchOfferCategories: 'offer/fetchOfferCategories',
            createStudentOwnInternship: 'student/createStudentOwnInternship',
            fetchStudentUniversities: 'student/fetchStudentUniversities'
        }),

        async submit() {
            this.showForm = false;

            await this.createStudentOwnInternship(this.data).then(() => {
                this.toggleDialog(false);
                this.setSnackbar({message: 'Udało się!', color: 'success'});
            }).catch((e) => {
                if (e.response !== undefined && e.response.status === 422) {
                    this.stepper = 1;
                    this.$refs.observerStepOne.setErrors(e.response.data.errors);
                    this.$refs.observerStepTwo.setErrors(e.response.data.errors);
                    this.$refs.observerStepThree.setErrors(e.response.data.errors);
                    this.showLoadingCircle = false;
                    this.showForm = true;
                } else {
                    setTimeout(() => {
                        this.showLoadingCircle = false;
                    }, 1000);
                    setTimeout(() => {
                        this.showForm = true;
                    }, 5000);
                }
            });
        },

        getCity(postcode) {
            this.fetchCity(postcode).then(() => {
                this.data.company.city.name = this.city.name ?? '';
                this.data.company.city.id = this.city.id ?? '';
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
            switch (this.data.company.city.postcode.length) {
                case 2:
                    this.data.company.city.postcode += '-';
            }
        },

        createBase64(file) {
            console.log(file);
            const reader = new FileReader();

            reader.onload = (e) => {
                this.data.agreement.attachment.name = file.name;
                this.data.agreement.attachment.mime = file.type;
                this.data.agreement.attachment.content = Base64.encode(e.target.result);
            };

            reader.readAsBinaryString(file);
        }
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

        this.fetchStudentUniversities().then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
