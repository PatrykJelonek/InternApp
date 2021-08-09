<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form>
            <v-row>
                <v-col cols="12" md="10">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="name"
                        rules="required|max:80"
                    >
                        <v-text-field
                            v-model="agreement.name"
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
                <v-col cols="12" md="2">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="placesNumber"
                        :rules="`required|min_value:1|max_value:${offer.places_number}`"
                    >
                        <v-text-field
                            v-model="agreement.placesNumber"
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
                <v-col cols="12" md="6">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="universitySupervisorId"
                        rules="required"
                    >
                        <v-select
                            v-model="selectedUniversity"
                            :items="userUniversities"
                            item-value="university.slug"
                            item-text="university.name"
                            :loading="userUniversitiesLoading"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                            @input="selectUniversity"
                        >
                            <template v-slot:label>
                                Uczelnia <sup class="red--text">*</sup>
                            </template>
                        </v-select>
                    </validation-provider>
                </v-col>
                <v-col cols="12" md="6">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="universitySupervisorId"
                        rules="required"
                    >
                        <v-autocomplete
                            v-model="agreement.universitySupervisorId"
                            :items="universityWorkers"
                            :item-text="(item) => item.first_name + ' ' + item.last_name"
                            item-value="id"
                            :loading="universityWorkersLoading"
                            :disabled="universityWorkers.length < 1"
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
                            v-model="agreement.program"
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
                            v-model="agreement.schedule"
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        ></v-textarea>
                    </validation-provider>
                </v-col>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="content"
                        rules=""
                    >
                        <v-textarea
                            label="Treść umowy"
                            v-model="agreement.content"
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
                                    v-model="agreement.dateFrom"
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
                            :min="offer.dateFrom"
                            :mix="getDecrementDateTo(agreement.dateTo, [1,'d'])"
                            v-model="agreement.dateFrom"
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
                                    v-model="agreement.dateTo"
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
                            v-model="agreement.dateTo"
                            :first-day-of-week="0"
                            locale="pl-pl"
                            no-title
                            :min="agreement.dateFrom"
                            :max="offer.dateTo"
                            @input="dateToPicker = false"
                        ></v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors }"
                        vid="attachments"
                    >
                        <v-file-input
                            label="Załącznik"
                            v-model="attachmentsFiles"
                            outlined
                            show-size
                            hide-details
                            multiple
                            prepend-icon=""
                            :error-messages="errors"
                        ></v-file-input>
                    </validation-provider>
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
        </v-form>
    </validation-observer>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import moment from 'moment';
import {Base64} from 'js-base64';
import PageLoader from "../_General/PageLoader";

export default {
    name: "CreateAgreementForm",
    props: ['offer'],

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            dateFromPicker: null,
            dateToPicker: null,
            selectedUniversity: null,
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
            attachmentsFiles: [],
        }
    },

    computed: {
        ...mapGetters({
            userUniversities: 'user/userUniversities',
            userUniversitiesLoading: 'user/userUniversitiesLoading',
            universityWorkers: 'university/workers',
            universityWorkersLoading: 'university/workersLoading',
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            fetchUserUniversities: 'user/fetchUserUniversities',
            fetchUniversityWorkers: 'university/fetchWorkers',
            createAgreement: 'agreement/createAgreement',
            toggleCreateAgreementDialog: 'helpers/toggleCreateAgreementDialog'
        }),

        async submit() {
            await this.$refs.observer.validate().then((value) => {
                if (value) {
                    this.createAgreement(this.agreement).then(() => {
                        this.setSnackbar({message: 'Umowa została dodana.', color: 'success'});
                        this.toggleCreateAgreementDialog(false);
                        this.agreement = null;
                    }).catch((e) => {
                        if (e.response.status === 422) {
                            console.log(e.response.data.errors);
                            this.$refs.observer.setErrors(e.response.data.errors);
                        }

                        this.setSnackbar({message: 'Nie udało się dodać umowy.', color: 'error'});
                    });
                }
            });
        },

        getDecrementDateTo(date, decrementValue) {
            if (date !== null) {
                return moment(date).subtract(...decrementValue).format('YYYY-MM-DD');
            }
            return moment().format('YYYY-MM-DD');
        },

        selectUniversity() {
            this.agreement.universitySlug = this.selectedUniversity;
            this.fetchUniversityWorkers(this.selectedUniversity);
        },
    },

    created() {
        this.$store.subscribe(mutation => {
            if (mutation.type === 'helper/TOGGLE_CREATE_OFFER_DIALOG' && !mutation.payload) {
                this.agreement = null;
            }
        });

        this.agreement.name = this.offer.name;
        this.agreement.placesNumber = this.offer.places_number;
        this.agreement.offerPlacesNumber = this.offer.places_number;
        this.agreement.dateFrom = this.offer.date_from;
        this.agreement.dateTo = this.offer.date_to;
        this.agreement.program = this.offer.program;
        this.agreement.schedule = this.offer.schedule;
        this.agreement.companyId = this.offer.company.id;
        this.agreement.offerId = this.offer.id;

        this.fetchUserUniversities().then(() => {
            if (this.userUniversities.length === 1) {
                this.selectedUniversity = this.userUniversities[0].university;
                this.agreement.universitySlug = this.userUniversities[0].university.slug;
                this.fetchUniversityWorkers(this.userUniversities[0].university.slug);
            }
        }).catch((e) => {

        });
    },
}
</script>

<style scoped>

</style>
