<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Informacje podstawowe</template>
        </custom-card-title>

        <v-row class="pa-5" no-gutters>
            <v-col cols="12">
                <validation-observer ref="observer" v-slot="{ validate }">
                    <v-form>
                        <v-row>
                            <v-col cols="12">
                                <validation-provider
                                    v-slot="{ errors, validate }"
                                    vid="email"
                                    rules="required|email"
                                >
                                    <v-text-field
                                        v-model="data.email"
                                        outlined
                                        dense
                                        hide-details="auto"
                                        :error-messages="errors"
                                        label="Email"
                                        @change="checkDataIsChanged"
                                    ></v-text-field>
                                </validation-provider>
                            </v-col>
                            <v-col cols="12">
                                <validation-provider
                                    v-slot="{ errors, validate }"
                                    vid="phone"
                                    rules="required|max:16"
                                >
                                    <v-text-field
                                        v-model="data.phone"
                                        outlined
                                        dense
                                        hide-details="auto"
                                        :error-messages="errors"
                                        label="Numer kontaktowy"
                                        @change="checkDataIsChanged"
                                    ></v-text-field>
                                </validation-provider>
                            </v-col>
                            <v-col cols="12">
                                <validation-provider
                                    v-slot="{ errors, validate }"
                                    vid="website"
                                    rules="required|max:64"
                                >
                                    <v-text-field
                                        v-model="data.website"
                                        outlined
                                        dense
                                        hide-details="auto"
                                        :error-messages="errors"
                                        label="Strona internetowa"
                                        @change="checkDataIsChanged"
                                    ></v-text-field>
                                </validation-provider>
                            </v-col>
                            <v-col cols="12">
                                <validation-provider
                                    v-slot="{ errors, validate }"
                                    vid="phone"
                                    rules="required|max:255"
                                >
                                    <v-textarea
                                        v-model="data.description"
                                        outlined
                                        dense
                                        hide-details="auto"
                                        :error-messages="errors"
                                        label="Opis firmy"
                                        @change="checkDataIsChanged"
                                    ></v-textarea>
                                </validation-provider>
                            </v-col>
                            <v-col cols="12" class="d-flex justify-end">
                                <v-btn
                                    color="primary"
                                    outlined
                                    :disabled="!isDataChanged"
                                    @click="submit"
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
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import {setInteractionMode, ValidationProvider, ValidationObserver, extend} from "vee-validate";
import {mapActions, mapGetters} from "vuex";

setInteractionMode('eager');

export default {
    name: "TheCompanySettingsData",
    components: {
        CustomCardTitle,
        CustomCard,
        ValidationProvider,
        ValidationObserver,
    },

    data() {
        return {
            data: {
                email: null,
                phone: null,
                website: null,
                description: null,
            },
            isDataChanged: false,
        }
    },

    computed: {
        ...mapGetters({
            company: 'company/company'
        })
    },

    methods: {
        ...mapActions({
            updateCompanyData: 'company/updateCompanyData',
            setSnackbar: 'snackbar/setSnackbar'
        }),

        checkDataIsChanged() {
            this.isDataChanged = this.data.email !== this.company.email ||
                this.data.phone !== this.company.phone ||
                this.data.website !== this.company.website ||
                this.data.description !== this.company.description;
        },

        async submit() {
            await this.$refs.observer.validate().then((isValid) => {
                if (isValid) {
                    this.updateCompanyData({slug: this.$route.params.slug, data: this.data}).then(() => {
                        this.setSnackbar({message: 'Dane zostały zmienione!', color: 'success'});
                    }).catch((e) => {
                        if (e.response.status === 422) {
                            console.log(e.response.data.errors);
                            this.$refs.observer.setErrors(e.response.data.errors);
                        }

                        this.setSnackbar({message: 'Nie udało się zmienić danych!', color: 'error'});
                    })
                }
            });
        }
    },

    created() {
        this.data.email = this.company.email;
        this.data.phone = this.company.phone;
        this.data.website = this.company.website;
        this.data.description = this.company.description;
    }
}
</script>

<style scoped>

</style>
