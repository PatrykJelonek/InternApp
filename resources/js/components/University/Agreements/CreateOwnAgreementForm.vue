<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form>
            <v-row>
                <v-col cols="12" class="pa-0">
                    <v-stepper v-model="stepper" class="card-background elevation-0" alt-labels>
                        <v-stepper-header class="elevation-0">
                            <v-stepper-step :complete="stepper > 1" step="1">
                                <span class="text-center">Miejsce Praktyk</span>
                            </v-stepper-step>
                            <v-divider></v-divider>
                            <v-stepper-step :complete="stepper > 2" step="2">
                                <span class="text-center">Dane Praktyki</span>
                            </v-stepper-step>
                            <v-divider></v-divider>
                            <v-stepper-step step="3">
                                <span class="text-center">Dane Umowy</span>
                            </v-stepper-step>
                        </v-stepper-header>

                        <v-stepper-items>
                            <v-stepper-content step="1">

                            </v-stepper-content>

                            <v-stepper-content step="2">

                            </v-stepper-content>

                            <v-stepper-content step="3">

                            </v-stepper-content>
                        </v-stepper-items>
                    </v-stepper>
                </v-col>
            </v-row>
        </v-form>
    </validation-observer>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import moment from 'moment';
import {Base64} from 'js-base64';

export default {
    name: "CreateOwnAgreementForm",

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            stepper: 1,
            dateFromPicker: null,
            dateToPicker: null,
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
                },
            },
            attachmentsFiles: [],
            canSearchable: null,
            searchCompanyInput: null,
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
            setSnackbar: 'snackbar/setSnackbar',
            fetchCompanyCategories: 'company/fetchCompanyCategories',
            fetchCompanies: 'company/fetchCompanies',
            fetchCity: 'city/fetchCity',
            fetchOfferCategories: 'offer/fetchOfferCategories',
            createStudentOwnInternship: 'student/createStudentOwnInternship'
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
