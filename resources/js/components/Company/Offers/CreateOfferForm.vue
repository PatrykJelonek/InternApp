<template>
    <v-form>
        <validation-observer ref="observer" v-slot="{ validate }">
            <v-row>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="offer.name"
                        rules="required"
                    >
                        <v-text-field
                            label="Nazwa Praktyki"
                            v-model="offer.name"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
                <v-col cols="10">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="offer.offerCategoryId"
                        rules="required"
                    >
                        <v-select
                            label="Kategoria Praktyk"
                            v-model="offer.offerCategoryId"
                            :items="offerCategories"
                            item-text="display_name"
                            item-value="id"
                            :loading="offerCategoriesLoading"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        ></v-select>
                    </validation-provider>
                </v-col>
                <v-col cols="2">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="offer.places_number"
                        rules="required|min_value:1"
                    >
                        <v-text-field
                            label="Ilość Miejsc"
                            v-model="offer.placesNumber"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="offer.companySupervisorId"
                        rules="required"
                    >
                        <v-autocomplete
                            label="Opiekun Praktyk"
                            v-model="offer.companySupervisorId"
                            :items="companyWorkers"
                            :item-text="(item) => item.first_name + ' ' + item.last_name"
                            item-value="id"
                            :loading="companyWorkersLoading"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        ></v-autocomplete>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="offer.program"
                        rules="required"
                    >
                        <v-textarea
                            label="Program Praktyk"
                            v-model="offer.program"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        ></v-textarea>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="offer.schedule"
                        rules=""
                    >
                        <v-textarea
                            label="Harmonogram Praktyk"
                            v-model="offer.schedule"
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
                                vid="offer.dateFrom"
                                rules="required"
                            >
                                <v-text-field
                                    v-model="offer.dateFrom"
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
                            v-model="offer.dateFrom"
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
                        nudge-left="50px"
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <validation-provider
                                v-slot="{ errors }"
                                vid="offer.dateTo"
                                rules="required"
                            >
                                <v-text-field
                                    v-model="offer.dateTo"
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
                            :min="getIncrementDateTo(offer.dateFrom, [1, 'd'])"
                            v-model="offer.dateTo"
                            @input="dateToPicker = false"
                        ></v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="offer.attachment"
                    >
                        <v-file-input
                            label="Załącznik"
                            v-model="attachmentsFiles"
                            outlined
                            show-size
                            hide-details
                            prepend-icon=""
                            @change="createBase64"
                            :error-messages="errors"
                        ></v-file-input>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <v-switch
                        v-model="offer.interview"
                        inset
                        hide-details
                        dense
                        class="mt-0"
                        label="Rozmowa kwalifikacyjna jest wymagana."
                    ></v-switch>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" class="d-flex justify-end">
                    <v-btn
                        outlined
                        color="primary"
                        @click="submit"
                    >
                        Dodaj
                    </v-btn>
                </v-col>
            </v-row>
        </validation-observer>
    </v-form>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import moment from 'moment';
import {Base64} from 'js-base64';

setInteractionMode('eager');

export default {
    name: "CreateOfferForm",

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            dateFromPicker: null,
            dateToPicker: null,
            offer: {
                name: null,
                placesNumber: 1,
                program: null,
                schedule: null,
                offerCategoryId: null,
                offerStatusId: null,
                companySupervisorId: null,
                dateFrom: null,
                dateTo: null,
                interview: false,
                attachments: []
            },
            attachmentsFiles: []
        }
    },

    computed: {
        ...mapGetters({
            company: 'company/company',
            companyCategories: 'company/companyCategories',
            companyCategoriesLoading: 'company/companyCategoriesLoading',
            offerCategories: 'offer/offerCategories',
            offerCategoriesLoading: 'offer/offerCategoriesLoading',
            companyWorkers: 'company/companyWorkers',
            companyWorkersLoading: 'company/companyWorkersLoading',
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchOfferCategories: 'offer/fetchOfferCategories',
            fetchCompanyWorkers: 'company/fetchCompanyWorkers',
            createOffer: 'offer/createOffer',
        }),

        async submit() {
            await this.createOffer(this.offer).then(() => {

            }).catch((e) => {
                if (e.response !== undefined && e.response.status === 422) {
                    this.$refs.observer.setErrors(e.response.data.errors);
                }
            });
        },

        createBase64(file) {

        },

        getIncrementDateTo(date, incrementValue) {
            if(date !== null) {
                return moment(date).add(...incrementValue).format('YYYY-MM-DD');
            }
            return moment().format('YYYY-MM-DD');
        }
    },

    created() {
        this.offer.companySupervisorId = this.company.id;
        this.fetchOfferCategories().then(() => {

        }).catch((e) => {

        });

        this.fetchCompanyWorkers(this.$route.params.slug).then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
