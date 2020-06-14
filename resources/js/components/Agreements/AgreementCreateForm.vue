<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form>
            <v-row>
                <v-col>
                    <v-menu
                        ref="menuDateFrom"
                        v-model="menuDateFrom"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <validation-provider v-slot="{ errors }" vid="dateFrom" rules="required">
                                <v-text-field
                                    v-model="agreement.dateFrom"
                                    label="Wybierz datę początkową umowy"
                                    placeholder="2020-02-02"
                                    outlined
                                    dense
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    :error-messages="errors"
                                    hide-details="auto"
                                ></v-text-field>
                            </validation-provider>
                        </template>
                        <v-date-picker v-model="agreement.dateFrom" no-title scrollable @input="menuDateFrom = false"></v-date-picker>
                    </v-menu>
                </v-col>
                <v-col>
                    <v-menu
                        ref="menuDateTo"
                        v-model="menuDateTo"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <validation-provider v-slot="{ errors }" vid="dateTo" rules="required">
                                <v-text-field
                                    v-model="agreement.dateTo"
                                    label="Wybierz datę końcową umowy"
                                    placeholder="2020-03-03"
                                    outlined
                                    dense
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    :error-messages="errors"
                                    hide-details="auto"
                                ></v-text-field>
                            </validation-provider>
                        </template>
                        <v-date-picker v-model="agreement.dateTo" no-title scrollable @input="menuDateTo = false"></v-date-picker>
                    </v-menu>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field
                        label="Firma"
                        :value="offer.company.name"
                        outlined
                        dense
                        hide-details="auto"
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col>
                    <v-text-field
                        label="Opiekun z firmy"
                        :value="offer.supervisor.first_name +' '+ offer.supervisor.last_name"
                        outlined
                        dense
                        hide-details="auto"
                        disabled
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="universityId" rules="required">
                        <v-select
                            label="Uczelnia"
                            v-model="agreement.universityId"
                            :items="userUniversities"
                            item-text="name"
                            item-value="id"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            no-data-text="Nie jesteś przypisany do żadnego uniwersytetu"
                            placeholder="Nazwa uczelni"
                            :readonly="isReadonly"
                            @change="fetchUniversityUsers(agreement.universityId)"
                        ></v-select>
                    </validation-provider>
                </v-col>
                <v-col>
                    <validation-provider v-slot="{ errors }" vid="companySupervisorId" rules="required">
                        <v-select
                            label="Opiekun z uczelni"
                            v-model="agreement.universitySupervisorId"
                            :items="universityUsers"
                            item-text="first_name"
                            item-value="id"
                            outlined
                            dense
                            hide-details="auto"
                            :disabled="!agreement.universityId"
                            :error-messages="errors"
                            no-data-text="..."
                            placeholder="Opiekun"
                        >
                            <template slot="selection" slot-scope="data">
                                <!-- HTML that describe how select should render selected items -->
                                {{ data.item.first_name }} {{ data.item.last_name }}
                            </template>
                            <template slot="item" slot-scope="data">
                                <!-- HTML that describe how select should render items when the select is open -->
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
                            v-model="agreement.program"
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
                            v-model="agreement.schedule"
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
                    <validation-provider v-slot="{ errors }" vid="content" rules="required">
                        <v-textarea
                            label="Treść porozumienia"
                            v-model="agreement.content"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            placeholder="Przykładowa treść porozumienia..."
                        ></v-textarea>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col class="d-flex justify-end">
                    <v-btn color="blue accent-4" large @click="submit" class="white--text">Dodaj porozumienie</v-btn>
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
        name: "AgreementCreateForm",

        components: {
            ValidationProvider,
            ValidationObserver
        },

        props: {
            offerId: String
        },

        data() {
            return {
                isReadonly: false,
                menuDateFrom: false,
                menuDateTo: false,
                agreement: {
                    signingDate: null,
                    dateFrom: null,
                    dateTo: null,
                    program: null,
                    schedule: null,
                    content: null,
                    companyId: null,
                    universityId: null,
                    universitySupervisorId: null,
                    offerId: null,
                }
            }
        },

        computed: {
            ...mapGetters({
                offer: 'offer/offer',
                userUniversities: 'user/userUniversities',
                universityUsers: 'university/universityUsers'
            }),
        },

        methods: {
            ...mapActions({
                fetchOffer: 'offer/fetchOffer',
                fetchUserUniversities: 'user/fetchUserUniversities',
                fetchUniversityUsers: 'university/fetchUniversityUsers',
                createAgreement: 'agreement/createAgreement'
            }),

            async submit() {
                this.$refs.observer.validate();

                await this.createAgreement(this.agreement).then(() => {
                    this.$router.replace('/offers');
                }).catch((e) => {
                    console.log(e.response.data);
                    if(e.response.status == 422) {
                        this.$refs.observer.setErrors(e.response.data.errors);
                    }
                });
            }
        },

        created() {
            this.fetchOffer(this.offerId).then(() => {
                this.agreement.program = this.offer.program;
                this.agreement.schedule = this.offer.schedule;
                this.agreement.companyId = this.offer.company_id;
                this.agreement.offerId = this.offer.id;
            });

            this.fetchUserUniversities();
        }
    };

    extend('required', {
        ...required,
        message: 'To pole jest wymagane!',
    });
</script>

<style scoped>

</style>
