<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form>
            <v-row class="pa-5">
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="name"
                        rules="required|max:80"
                    >
                        <v-text-field
                            v-model="offer.name"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        >
                            <template v-slot:label>
                                Nazwa Praktyki <sup class="red--text">*</sup>
                            </template>
                        </v-text-field>
                    </validation-provider>
                </v-col>
                <v-col cols="10">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="offerCategoryId"
                        rules="required"
                    >
                        <v-select
                            v-model="offer.offerCategoryId"
                            :items="offerCategories"
                            item-text="display_name"
                            item-value="id"
                            :loading="offerCategoriesLoading"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        >
                            <template v-slot:label>
                                Kategoria Praktyk <sup class="red--text">*</sup>
                            </template>
                        </v-select>
                    </validation-provider>
                </v-col>
                <v-col cols="2">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="placesNumber"
                        rules="required|min_value:1"
                    >
                        <v-text-field
                            v-model="offer.placesNumber"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        >
                            <template v-slot:label>
                                Ilość Miejsc <sup class="red--text">*</sup>
                            </template>
                        </v-text-field>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="companySupervisorId"
                        rules="required"
                    >
                        <v-autocomplete
                            v-model="offer.companySupervisorId"
                            :items="companyWorkers"
                            :item-text="(item) => item.first_name + ' ' + item.last_name"
                            item-value="id"
                            :loading="companyWorkersLoading"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        >
                            <template v-slot:label>
                                Opiekun Praktyk <sup class="red--text">*</sup>
                            </template>
                        </v-autocomplete>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="program"
                        rules="required"
                    >
                        <v-textarea
                            v-model="offer.program"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        >
                            <template v-slot:label>
                                Program Praktyk <sup class="red--text">*</sup>
                            </template>
                        </v-textarea>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="schedule"
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
                                vid="dateFrom"
                                rules="required"
                            >
                                <v-text-field
                                    v-model="offer.dateFrom"
                                    hide-details="auto"
                                    :error-messages="errors"
                                    readonly
                                    outlined
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <template v-slot:label>
                                        Data Rozpoczęcia <sup class="red--text">*</sup>
                                    </template>
                                </v-text-field>
                            </validation-provider>
                        </template>
                        <v-date-picker
                            :first-day-of-week="0"
                            locale="pl-pl"
                            no-title
                            :min="getTodayDate()"
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
                                vid="dateTo"
                                rules="required"
                            >
                                <v-text-field
                                    v-model="offer.dateTo"
                                    hide-details="auto"
                                    :error-messages="errors"
                                    readonly
                                    outlined
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <template v-slot:label>
                                        Data Zakończenia <sup class="red--text">*</sup>
                                    </template>
                                </v-text-field>
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
                        vid="attachment"
                    >
                        <v-file-input
                            label="Załącznik"
                            v-model="offer.attachment"
                            outlined
                            show-size
                            hide-details
                            small-chips
                            prepend-icon=""
                            :error-messages="errors"
                            accept=".pdf,.docx"
                        ></v-file-input>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="interview"
                    >
                        <v-switch
                            v-model="offer.interview"
                            inset
                            hide-details
                            dense
                            class="mt-0"
                            label="Rozmowa kwalifikacyjna jest wymagana."
                            :error-messages="errors"
                            :true-value="1"
                            :false-value="0"
                        ></v-switch>
                    </validation-provider>
                </v-col>
            </v-row>
            <custom-card-footer>
                <template v-slot:right>
                    <v-btn
                        outlined
                        color="primary"
                        @click="submit"
                    >
                        Dodaj
                    </v-btn>
                </template>
            </custom-card-footer>
        </v-form>
    </validation-observer>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import moment from 'moment';
import {Base64} from 'js-base64';
import PageLoader from "../../_General/PageLoader";
import CustomCardFooter from "../../_General/CustomCardFooter";

setInteractionMode('eager');

export default {
    name: "CreateOfferForm",

    props: ['updateFunction'],

    components: {
        CustomCardFooter,
        PageLoader,
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            dateFromPicker: null,
            dateToPicker: null,
            offer: {
                companyId: null,
                name: '',
                placesNumber: 1,
                program: '',
                schedule: '',
                offerCategoryId: null,
                companySupervisorId: null,
                dateFrom: null,
                dateTo: null,
                interview: 0,
                attachment: null,
            },
            attachment: null,
            attachmentsFiles: [],
            tempBase64File: null,
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
            toggleCreateOfferDialog: 'helpers/toggleCreateOfferDialog',
            fetchCompanyOffers: 'company/fetchCompanyOffers',
            createOffer: 'offer/createOffer',
        }),

        async submit() {
            await this.$refs.observer.validate().then((value) => {
                if (value) {
                    this.submitLoading = true;
                    let formData = new FormData();

                    for (const prop in this.offer) {
                        formData.append(prop, this.offer[prop]);
                    }

                    this.createOffer(formData).then((offer) => {
                        this.setSnackbar({message: 'Oferta została dodana!', color: 'success'});
                        this.toggleCreateOfferDialog(false);
                        this.fetchCompanyOffers(this.company.slug);
                    }).catch((e) => {
                        if (e.response !== undefined && e.response.status === 422) {
                            this.$refs.observer.setErrors(e.response.data.errors);
                        } else {
                            this.toggleCreateOfferDialog(false);
                        }
                    });
                }
            });
        },

        async convertToBase64(file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                this.tempBase64File = {
                    name: file.name,
                    mime: file.type,
                    content: Base64.encode(e.target.result),
                };
            };

            await reader.readAsBinaryString(file);
        },

        getIncrementDateTo(date, incrementValue) {
            if (date !== null) {
                return moment(date).add(...incrementValue).format('YYYY-MM-DD');
            }
            return moment().format('YYYY-MM-DD');
        },

        getTodayDate() {
            return moment().format('YYYY-MM-DD');
        }
    },

    created() {
        this.offer.companyId = this.company.id;
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
