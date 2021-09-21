<template>
    <custom-card :loading="loading">
        <custom-card-title>
            <template v-slot:default>Dane uczelni</template>
        </custom-card-title>
        <v-row no-gutters class="pa-5 mt-2">
            <v-col cols="12">
                <validation-observer ref="observer" v-slot="{ validate }">
                    <v-form>
                        <v-row>
                            <v-col cols="12">
                                <validation-provider
                                    v-slot="{ errors }"
                                    vid="email"
                                    rules="required"
                                >
                                    <v-text-field
                                        v-model="email"
                                        label="Adres email"
                                        :value="university.email"
                                        outlined
                                        hide-details="auto"
                                        :error-messages="errors"
                                        dense
                                        :disabled="!hasUniversityRole(['deanery_worker','university_owner'])"
                                    ></v-text-field>
                                </validation-provider>
                            </v-col>
                            <v-col cols="12">
                                <validation-provider
                                    v-slot="{ errors }"
                                    vid="website"
                                    rules="required"
                                >
                                    <v-text-field
                                        v-model="website"
                                        label="Strona internetowa"
                                        :value="university.website"
                                        outlined
                                        hide-details="auto"
                                        :error-messages="errors"
                                        dense
                                        :disabled="!hasUniversityRole(['deanery_worker','university_owner'])"
                                    ></v-text-field>
                                </validation-provider>
                            </v-col>
                            <v-col cols="12">
                                <validation-provider
                                    v-slot="{ errors }"
                                    vid="phone"
                                    rules="required"
                                >
                                    <v-text-field
                                        v-model="phone"
                                        label="Numer telefonu"
                                        :value="university.phone"
                                        outlined
                                        hide-details="auto"
                                        :error-messages="errors"
                                        dense
                                        v-mask="'###-###-###'"
                                        :disabled="!hasUniversityRole(['deanery_worker','university_owner'])"
                                    ></v-text-field>
                                </validation-provider>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" class="d-flex justify-end">
                                <v-btn
                                    outlined
                                    color="primary"
                                    @click="send"
                                    v-if="hasUniversityRole(['deanery_worker','university_owner'])"
                                >
                                    Zapisz
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                </validation-observer>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import {hasUniversityRole} from "../../../plugins/acl";
import university from "../../../store/modules/university";
import {extend, setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";

setInteractionMode('eager');

export default {
    name: "TheUniversitySettingsForm",
    components: {CustomCardTitle, CustomCard,ValidationObserver, ValidationProvider},
    data() {
        return {
            show: true,
            tabs: null,
            email: null,
            website: null,
            phone: null,
            loading: false,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
        }),
    },

    methods: {
        hasUniversityRole,

        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            updateUniversityData: 'university/updateUniversityData'
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },

        async send() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {
                    this.loading = true;
                    this.updateUniversityData({
                        slug: this.$route.params.slug,
                        email: this.email,
                        website: this.website,
                        phone: this.phone,
                    }).then(() => {
                        this.setSnackbar({message: 'Dane zostały zmienione!', color: 'success'})
                    }).catch((e) => {
                        if (e.response.status === 422) {
                            this.$refs.observerWorker.setErrors(e.response.data.errors);
                        } else {
                            this.setSnackbar({message: 'Ups... Wystąpił problem!', color: 'error'});
                        }
                    }).finally(() => {
                        this.loading = false;
                    })
                }
            });
        },
    },

    created() {
        this.email = this.university.email;
        this.website = this.university.website;
        this.phone = this.university.phone;
    }
}
</script>

<style scoped>

</style>
