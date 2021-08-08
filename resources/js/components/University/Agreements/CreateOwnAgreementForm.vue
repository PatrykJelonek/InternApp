<template>
    <v-container fluid class="pa-0 ma-0">
        <v-stepper alt-labels v-model="createOwnAgreementStepper" flat color="component-background">
            <!-- STEPPER HEADER -->
            <v-stepper-header class="component-background mt-0">
                <v-stepper-step step="1" :rules="stepOneErrors">Miejsce praktyk</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="2" :rules="stepTwoErrors">Dane praktyki</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="3" :rules="stepThreeErrors">Dane umowy</v-stepper-step>
            </v-stepper-header>

            <v-divider></v-divider>

            <!-- STEPPER CONTENTS -->
            <v-stepper-items>
                <v-stepper-content step="1" class="component-background pa-0">
                    <template>
                        <v-row no-gutters class="pa-5">
                            <v-col cols="12">
                                <validation-provider
                                    vid="company.id"
                                    rules="required"
                                    v-slot="{ errors }"
                                >
                                    <v-autocomplete
                                        v-model="data.company.id"
                                        :items="companies"
                                        item-text="name"
                                        item-value="id"
                                        :loading="companiesLoading"
                                        outlined
                                        dense
                                        label="Firma"
                                        hide-details="auto"
                                        clearable
                                    ></v-autocomplete>
                                </validation-provider>
                            </v-col>
                            <v-col cols="12" class="mt-5 text-center">
                                <p class="text-body-2 ma-0">
                                    Nie znalazłeś szukanej firmy?
                                    <span
                                        class="primary--text cursor-pointer">Uzupełnij poniższy formularz!</span>
                                </p>
                            </v-col>
                        </v-row>
                    </template>
                    <v-divider></v-divider>
                    <validation-observer ref="observerStepOne" v-slot="{ validate }">
                        <v-form>
                            <template>
                                <v-row no-gutters class="pa-5">
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="company.name"
                                            rules="required|max:64"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.name"
                                                outlined
                                                dense
                                                label="Nazwa firmy"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="8" class="pr-5">
                                        <validation-provider
                                            vid="company.street"
                                            rules="required|max:64"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.street"
                                                outlined
                                                dense
                                                label="Ulica"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="4">
                                        <validation-provider
                                            vid="company.streetNumber"
                                            rules="required|max:8"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.streetNumber"
                                                outlined
                                                dense
                                                label="Numer"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="4" class="pr-5">
                                        <validation-provider
                                            vid="company.city.postcode"
                                            rules="required|max:6"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.city.postcode"
                                                outlined
                                                dense
                                                v-mask="'##-###'"
                                                label="Kod pocztowy"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="8">
                                        <validation-provider
                                            vid="company.city.name"
                                            rules="required_if:company.id"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.city.name"
                                                outlined
                                                dense
                                                label="Miasto"
                                                disabled
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="company.companyCategoryId"
                                            rules="required|numeric"
                                            v-slot="{ errors }"
                                        >
                                            <v-autocomplete
                                                v-model="data.company.companyCategoryId"
                                                :items="companyCategories"
                                                item-text="name"
                                                item-value="id"
                                                :loading="companyCategoriesLoading"
                                                outlined
                                                dense
                                                label="Kategoria"
                                                :error-messages="errors"
                                            ></v-autocomplete>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="6" class="pr-5">
                                        <validation-provider
                                            vid="company.email"
                                            rules="required|email"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.email"
                                                outlined
                                                dense
                                                label="Email"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="6">
                                        <validation-provider
                                            vid="company.phone"
                                            rules="required|regex:/^/d{3}-/d{3}-/d{3}/|max-16"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.phone"
                                                outlined
                                                dense
                                                prefix="+48 "
                                                v-mask="'###-###-###'"
                                                label="Telefon kontaktowy"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="company.website"
                                            rules="required|max:64"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.company.website"
                                                outlined
                                                dense
                                                prefix="https://"
                                                label="Strona internetowa"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea
                                            v-model="data.company.description"
                                            outlined
                                            dense
                                            label="Opis firmy"
                                            :error-messages="errors"
                                        ></v-textarea>
                                    </v-col>
                                </v-row>
                            </template>
                        </v-form>
                    </validation-observer>
                </v-stepper-content>

                <v-stepper-content step="2" class="component-background pa-0">
                    <validation-observer ref="observerStepTwo" v-slot="{ validate }">
                        <v-form>
                            <template>
                                <v-row no-gutters class="pa-5">
                                    <v-col cols="10" class="pr-5">
                                        <validation-provider
                                            vid="agreement.name"
                                            rules="required|max:80"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.agreement.name"
                                                outlined
                                                dense
                                                label="Nazwa praktyki"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="2">
                                        <validation-provider
                                            vid="agreement.placesNumber"
                                            rules="required|min_value:0|numeric"
                                            v-slot="{ errors }"
                                        >
                                            <v-text-field
                                                v-model="data.agreement.placesNumber"
                                                outlined
                                                dense
                                                label="Ilość miejsc"
                                                :error-messages="errors"
                                            ></v-text-field>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="6" class="pr-5">
                                        <v-menu
                                            v-model="dateFromPicker"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto"
                                            :error-messages="errors"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <validation-provider
                                                    vid="agreement.dateFrom"
                                                    rules="required"
                                                    v-slot="{ errors }"
                                                >
                                                    <v-text-field
                                                        v-model="data.agreement.dateFrom"
                                                        label="Data od"
                                                        readonly
                                                        outlined
                                                        dense
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </template>
                                            <v-date-picker
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
                                                    vid="agreement.dateTo"
                                                    rules="required"
                                                    v-slot="{ errors }"
                                                >
                                                    <v-text-field
                                                        v-model="data.agreement.dateTo"
                                                        label="Data do"
                                                        readonly
                                                        outlined
                                                        dense
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </template>
                                            <v-date-picker
                                                v-model="data.agreement.dateTo"
                                                @input="dateToPicker = false"
                                            ></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="agreement.universitySupervisorId"
                                            rules="required"
                                            v-slot="{ errors }"
                                        >
                                            <v-autocomplete
                                                v-model="data.agreement.universitySupervisorId"
                                                :items="universityWorkers"
                                                item-text="full_name"
                                                item-value="id"
                                                outlined
                                                dense
                                                label="Opiekun praktyk"
                                                :error-messages="errors"
                                            ></v-autocomplete>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="agreement.program"
                                            rules="required"
                                            v-slot="{ errors }"
                                        >
                                            <v-textarea
                                                v-model="data.agreement.program"
                                                outlined
                                                dense
                                                label="Program praktyk"
                                                :error-messages="errors"
                                            ></v-textarea>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="agreement.schedule"
                                            rules="required"
                                            v-slot="{ errors }"
                                        >
                                            <v-textarea
                                                v-model="data.agreement.schedule"
                                                outlined
                                                dense
                                                label="Harmonogram praktyk"
                                                :error-messages="errors"
                                            ></v-textarea>
                                        </validation-provider>
                                    </v-col>
                                </v-row>
                            </template>
                        </v-form>
                    </validation-observer>
                </v-stepper-content>

                <v-stepper-content step="3" class="component-background pa-0">
                    <validation-observer ref="observerStepThree" v-slot="{ validate }">
                        <v-form>
                            <template>
                                <v-row no-gutters class="pa-5">
                                    <v-col cols="12">
                                        <v-menu
                                            v-model="dateSigningPicker"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <validation-provider
                                                    vid="agreement.signingDate"
                                                    rules="required"
                                                    v-slot="{ errors }"
                                                >
                                                    <v-text-field
                                                        v-model="data.agreement.signingDate"
                                                        label="Data podpisania umowy"
                                                        readonly
                                                        outlined
                                                        dense
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        :error-messages="errors"
                                                    ></v-text-field>
                                                </validation-provider>
                                            </template>
                                            <v-date-picker
                                                v-model="data.agreement.signingDate"
                                                @input="dateSigningPicker = false"
                                            ></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12">
                                        <validation-provider
                                            vid="agreement.content"
                                            rules="required"
                                            v-slot="{ errors }"
                                        >
                                            <v-textarea
                                                v-model="data.agreement.content"
                                                outlined
                                                dense
                                                label="Treść umowy"
                                                :error-messages="errors"
                                            ></v-textarea>
                                        </validation-provider>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-file-input
                                            outlined
                                            dense
                                            multiple
                                            prepend-icon=""
                                            prepend-inner-icon="mdi-paperclip"
                                            label="Załączniki do umowy"
                                            :error-messages="errors"
                                        ></v-file-input>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-checkbox
                                            class="ma-0"
                                            v-model="data.agreement.active"
                                            label="Umowa aktywna (widoczna dla studentów)"
                                            hide-details="auto"
                                            :error-messages="errors"
                                        ></v-checkbox>
                                    </v-col>
                                </v-row>
                            </template>
                        </v-form>
                    </validation-observer>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {setInteractionMode, ValidationProvider, ValidationObserver, extend} from "vee-validate";
import moment from 'moment';
import {Base64} from 'js-base64';
import {max, regex} from "vee-validate/dist/rules";

export default {
    name: "CreateOwnAgreementForm",

    props: ['step'],

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            d: true,
            stepper: 1,
            dateFromPicker: null,
            dateToPicker: null,
            dateSigningPicker: null,
            selectedUniversity: null,
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
                    description: null,
                },
                agreement: {
                    name: null,
                    dateFrom: null,
                    dateTo: null,
                    program: null,
                    schedule: null,
                    content: null,
                    companyId: null,
                    universitySlug: null,
                    universitySupervisorId: null,
                    offerId: null,
                    userId: null,
                    attachments: [],
                    placesNumber: null,
                    offerPlacesNumber: null,
                    active: false,
                    signingDate: null,
                },
            },
            attachmentsFiles: [],
            canSearchable: null,
            searchCompanyInput: null,
            stepOneErrors: false,
            stepTwoErrors: false,
            stepThreeErrors: false,
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
            universityWorkers: 'university/workers',
            createOwnAgreementStepper: 'helpers/createOwnAgreementStepper',
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
            fetchUniversityWorkers: 'university/fetchWorkers',
            setCreateOwnAgreementStepper: 'helpers/setCreateOwnAgreementStepper',
        }),

        postcodePattern() {
            switch (this.data.company.city.postcode.length) {
                case 2:
                    this.data.company.city.postcode += '-';
            }
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

    },

    created() {
        this.fetchCompanies().then(() => {

        }).catch((e) => {

        });

        this.fetchCompanyCategories().then(() => {

        }).catch((e) => {

        });

        this.fetchOfferCategories().then(() => {

        }).catch((e) => {

        });

        this.fetchUniversityWorkers(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    },

    watch: {
        createOwnAgreementStepper: function (newVal, oldVal) {
            if (newVal > oldVal) {
                switch (oldVal) {
                    case 1:
                        if (this.data.company.id === null || this.data.company.name !== null) {
                            this.$refs.observerStepOne.validate().then((isValid) => {
                                if (isValid) {
                                    console.log('asd 1');
                                } else {
                                    this.stepOneErrors = true;
                                    this.setCreateOwnAgreementStepper(1);
                                }
                            });
                        } else {
                            this.$refs.observerStepOne.reset();
                        }
                        break;
                    case 2:
                        this.$refs.observerStepTwo.validate().then((isValid) => {
                            if (isValid) {
                                console.log('asd 2');
                            } else {
                                this.stepTwoErrors = true;
                                this.setCreateOwnAgreementStepper(2);
                            }
                        });
                        break;
                    case 3:
                        this.$refs.observerStepThree.validate().then((isValid) => {
                            if (isValid) {
                                console.log('asd 2');
                            } else {
                                this.stepThreeErrors = true;
                                this.setCreateOwnAgreementStepper(3);
                            }
                        });
                        break;
                }
            }
        }
    }
}

extend('regex', {
    ...regex,
    message: "Zły format numeru"
});

</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
