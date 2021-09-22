<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Kod dostępu</template>
            <template v-slot:actions>
                <v-btn icon @click="generateAccessCode" v-has-company-role="['company_owner', 'company_manager']">
                    <v-icon>mdi-cached</v-icon>
                </v-btn>
            </template>
        </custom-card-title>
        <v-row no-gutters>
            <v-col cols="12" class="fill-height d-flex justify-center align-center">
                <v-form class="ma-5">
                    <v-text-field
                        label="Kod dostępu"
                        v-model="company.access_code"
                        readonly
                        outlined
                        hide-details dense
                        append-icon="mdi-content-copy"
                        :loading="codeLoading"
                        @click:append="copyAccessCode"
                    ></v-text-field>
                </v-form>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
import {mapActions, mapGetters} from "vuex";
import moment from "moment";

export default {
    name: "TheCompanyAccessCode",
    components: {CustomCardTitle, CustomCard},

    data() {
        return {
            show: true,
        }
    },

    computed: {
        ...mapGetters({
            company: 'company/company',
            codeLoading: 'company/codeLoading'
        }),
    },

    methods: {
        ...mapActions({
            generateNewAccessCode: 'company/generateCode',
            setSnackbar: 'snackbar/setSnackbar',
        }),

        copyAccessCode() {
            navigator.clipboard.writeText(this.company.access_code).then(() => {
                this.setSnackbar({message: 'Skopiowano kod: ' + this.company.access_code, color: 'success'});
            });
        },

        generateAccessCode() {
            this.generateNewAccessCode({slug: this.company.slug}).then(() => {
                this.setSnackbar({message: 'Wygenerowano nowy kod!', color: 'success'});
            }).catch((e) => {
                this.setSnackbar({message: 'Coś poszło nie tak!', color: 'error'});
            });
        },

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        }
    },

}
</script>

<style scoped>

</style>
