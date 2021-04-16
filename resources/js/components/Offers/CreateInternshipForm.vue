<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form class="pa-5">
            <v-row>
                <v-col cols="12">
                    <v-stepper v-model="stepper" class="card-background elevation-0">
                        <v-stepper-header class="elevation-0">
                            <v-stepper-step :complete="stepper > 1" step="1">Miejsce Praktyk</v-stepper-step>
                            <v-divider></v-divider>
                            <v-stepper-step :complete="stepper > 2" step="2">Informacje Ogólne</v-stepper-step>
                            <v-divider></v-divider>
                            <v-stepper-step step="3">Name of step 3</v-stepper-step>
                        </v-stepper-header>

                        <v-stepper-items class="elevation-0">
                            <v-stepper-content step="1">
                                <v-expand-transition>
                                    <v-row v-if="searchCompanyInput && canSearchable" class="mt-1" v>
                                        <v-col cols="12" class="text-center subtitle-1">
                                            Sprawdź czy nie ma już twojej firmy w naszym systemie.
                                        </v-col>
                                        <v-col cols="12">
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
                                                hide-details
                                            ></v-autocomplete>
                                        </v-col>
                                    </v-row>
                                </v-expand-transition>
                                <v-row v-if="canSearchable">
                                    <v-col cols="12" class="text-center">
                                        <v-btn
                                            @click="searchCompanyInput = !searchCompanyInput; data.company.id = null; canGoNext = false"
                                            outlined small color="primary"
                                            :class="searchCompanyInput ?? 'mb-2'"
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
                                            <v-btn color="primary" outlined @click="stepper++">
                                                Dalej
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-expand-transition>
                                <v-expand-transition>
                                    <v-row v-if="!searchCompanyInput" class="mt-1">
                                        <v-col cols="7">
                                            <v-text-field
                                                label="Nazwa Firmy"
                                                v-model="data.company.name"
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="5">
                                            <v-select
                                                label="Kategoria Firmy"
                                                v-model="data.company.categoryId"
                                                :items="companyCategories"
                                                item-text="name"
                                                item-value="id"
                                                :loading="companyCategoriesLoading"
                                                outlined
                                                hide-details
                                            ></v-select>
                                        </v-col>
                                        <v-col cols="8">
                                            <v-text-field
                                                label="Ulica"
                                                v-model="data.company.street"
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-text-field
                                                label="Nr Budynku"
                                                v-model="data.company.streetNumber"
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-text-field
                                                label="Kod Pocztowy"
                                                v-model="data.company.cityPostCode"
                                                @focusout="getCity(data.company.cityPostCode)"
                                                v-on:input="postcodePattern"
                                                maxlength="6"
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="8">
                                            <v-text-field
                                                label="Miasto"
                                                v-model="data.company.cityName"
                                                :loading="cityLoading"
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-text-field
                                                label="Email Firmowy"
                                                v-model="data.company.email"
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-text-field
                                                label="Telefon Firmowy"
                                                v-model="data.company.phone"
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                label="Strona Firmowa"
                                                v-model="data.company.website"
                                                hint="www.example.com"
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-row>
                                                <v-col cols="12" class="text-right">
                                                    <v-btn outlined color="primary" @click="stepper++">
                                                        Dalej
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </v-expand-transition>
                            </v-stepper-content>
                            <v-stepper-content step="2">
                                <v-row>
                                    <v-col cols="12">

                                    </v-col>
                                    <v-col cols="12">

                                    </v-col>
                                    <v-col cols="12">

                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="6" class="text-left">
                                        <v-btn color="grey darken-2" outlined @click="stepper--">
                                            Cofnij
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="6" class="text-right">
                                        <v-btn outlined color="primary" @click="stepper++">
                                            Dalej
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-stepper-content>
                            <v-stepper-content step="3">
                                <v-row>
                                    <v-col cols="12">

                                    </v-col>
                                    <v-col cols="12">

                                    </v-col>
                                    <v-col cols="12">

                                    </v-col>

                                </v-row>
                                <v-row>
                                    <v-col cols="12" class="text-left">
                                        <v-btn outlined @click="stepper--">
                                            Cofnij
                                        </v-btn>
                                    </v-col>
                                </v-row>
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
        }),
    },

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleCreateInternshipDialog',
            fetchCompanyCategories: 'company/fetchCompanyCategories',
            fetchCompanies: 'company/fetchCompanies',
            fetchCity: 'city/fetchCity',
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

        updateData() {

        },

        postcodePattern() {
            switch (this.data.company.cityPostCode.length) {
                case 2:
                    this.data.company.cityPostCode += '-';
            }
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
    }
}
</script>

<style scoped>

</style>
