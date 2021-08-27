<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Logo</template>
        </custom-card-title>
        <v-row no-gutters class="pa-5">
            <v-col cols="12" class="d-flex justify-center">
                <v-avatar rounded size="120" :color="logoPreview || university.logo_url ? '' : 'primary'" class="text-h5">
                    <v-img :src="logoPreview !== null ? logoPreview : '/'+university.logo_url"
                           :alt="'Logo firmy ' + university.name">
                        <v-overlay absolute :value="loadPreview">
                            <v-progress-circular indeterminate size="64"></v-progress-circular>
                        </v-overlay>
                    </v-img>
                </v-avatar>
            </v-col>
            <v-col cols="12" class="mt-5">
                <v-form>
                    <validation-observer ref="observer" v-slot="{ validate }">
                        <validation-provider
                            v-slot="{ errors, validate }"
                            vid="avatar"
                            rules="mimes:image/jpeg,image/png"
                        >
                            <v-file-input
                                v-model="logo"
                                outlined
                                dense
                                hide-details="auto"
                                :error-messages="errors"
                                label="Kliknij, by zmienić logo"
                                accept="image/jpeg,image/png"
                                @change="setLogoPreview"
                                prepend-icon=""
                            ></v-file-input>
                        </validation-provider>
                    </validation-observer>
                </v-form>
            </v-col>
            <v-col cols="12" class="d-flex justify-end mt-6">
                <v-btn
                    color="primary"
                    outlined
                    :disabled="logo === null"
                    @click="submit"
                >
                    Zapisz
                </v-btn>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import CustomCardTitle from "../../_General/CustomCardTitle";
import CustomCard from "../../_General/CustomCard";
import {ValidationObserver, ValidationProvider} from "vee-validate";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "TheUniversityChangeLogo",
    components: {
        CustomCardTitle,
        CustomCard,
        ValidationProvider,
        ValidationObserver,
    },

    data() {
        return {
            logoPreview: null,
            loadPreview: false,
            logo: null,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar',
            updateUniversityLogo: 'university/updateUniversityLogo'
        }),

        setLogoPreview() {
            this.loadPreview = true;
            if (this.logo) {
                this.logoPreview = URL.createObjectURL(this.logo);
            } else {
                this.logoPreview = ''
            }
            this.loadPreview = false;
        },

        submit() {
            let formData = new FormData();
            formData.append('logo', this.logo);

            this.updateCompanyLogo({slug: this.$route.params.slug, data: formData}).then((response) => {
                this.setSnackbar({message: 'Logo zostało zmienione!', color: 'success'});
            });
        }
    }
}
</script>

<style scoped>

</style>
