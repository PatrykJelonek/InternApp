<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
        <template v-slot:activator="{ on }">
            <v-list-item v-on="on" dense>
                <v-list-item-title >Użyj kodu</v-list-item-title>
            </v-list-item>
        </template>
        <v-card>
            <v-card-title>
                <span class="text-uppercase title font-weight-black grey--text text--darken-4">Dołącz do uczelni</span>
            </v-card-title>
            <v-card-text class="pb-0">
                <v-container>
                    <v-row>
                        <v-col cols="12" class="pa-0">
                            <validation-observer ref="observer" v-slot="{ validate }">
                                <validation-provider v-slot="{ errors }"  vid="accessCode" rules="required|max:8|min:8">
                                    <v-text-field
                                        v-model="code"
                                        label="Kod"
                                        required
                                        outlined
                                        hide-details="auto"
                                        :error-messages="errors"
                                        :counter="8"
                                    ></v-text-field>
                                </validation-provider>
                            </validation-observer>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue accent-4" text @click="dialog = false">Anuluj</v-btn>
                <v-btn color="blue accent-4" dark @click="jointToCompany">Dołącz</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {mapActions} from "vuex";
    import { required, max, min } from "vee-validate/dist/rules";
    import {  extend, setInteractionMode, ValidationProvider, ValidationObserver } from "vee-validate";

    setInteractionMode('eager');

    export default {
        name: "CompanyUseCodeDialog",

        components: {
            ValidationProvider,
            ValidationObserver
        },

        data() {
            return {
                code: '',
                dialog: false,
            }
        },
        methods: {
            ...mapActions({
                useCode: 'company/useCode'
            }),

            jointToCompany() {
                this.useCode(this.code).then(() => {
                    this.$store.dispatch('user/fetchUserCompanies');
                    this.dialog = false;
                }).catch((e) => {
                    console.log(e.response);
                    this.$refs.observer.setErrors({
                        accessCode: [e.response.data.message],
                    });
                })
            },
        }
    };

    extend('required', {
        ...required,
        message: 'Musisz podać kod!',
    });

    extend('min', {
        ...min,
        message: "Kod nie może być krótszy niż {length} znaków!"
    })

    extend('max', {
        ...max,
        message: "Kod nie może być dłuższy niż {length} znaków!"
    });
</script>

<style scoped>

</style>
