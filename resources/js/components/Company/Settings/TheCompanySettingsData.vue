<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Informacje podstawowe</template>
        </custom-card-title>

        <v-row class="pa-5" no-gutters>
            <v-col cols="12">
                <v-form>
                    <v-row>
                        <v-col cols="12">
                            <validation-provider
                                v-slot="{ errors, validate }"
                                vid="email"
                                rules="required|email"
                            >
                                <v-text-field
                                    v-model="company.email"
                                    outlined
                                    dense
                                    hide-details="auto"
                                    :error-messages="errors"
                                    label="Email"
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
                                    v-model="company.phone"
                                    outlined
                                    dense
                                    hide-details="auto"
                                    :error-messages="errors"
                                    label="Numer kontaktowy"
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
                                    v-model="company.website"
                                    outlined
                                    dense
                                    hide-details="auto"
                                    :error-messages="errors"
                                    label="Strona internetowa"
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
                                    v-model="company.description"
                                    outlined
                                    dense
                                    hide-details="auto"
                                    :error-messages="errors"
                                    label="Opis firmy"
                                ></v-textarea>
                            </validation-provider>
                        </v-col>
                        <v-col cols="12" class="d-flex justify-end">
                            <v-btn color="primary" outlined>Zapisz</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
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
            }
        }
    },

    computed: {
        ...mapGetters({
            company: 'company/company'
        })
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
