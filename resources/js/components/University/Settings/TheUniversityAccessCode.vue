<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Kod dostępu</template>
        </custom-card-title>
        <v-row>
            <v-col cols="12">
                <v-form class="ma-5">
                    <v-text-field
                        label="Kod dostępu"
                        :value="university.access_code"
                        readonly
                        outlined
                        hide-details dense
                        append-outer-icon="mdi-cached"
                        append-icon="mdi-content-copy"
                        :loading="codeLoading"
                        @click:append-outer="generateAccessCode"
                        @click:append="copyAccessCode"
                    ></v-text-field>
                </v-form>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheUniversityAccessCode",
    components: {CustomCardTitle, CustomCard},
    data() {
        return {
            show: true,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            codeLoading: 'university/codeLoading'
        }),
    },

    methods: {
        ...mapActions({
            generateNewAccessCode: 'university/generateCode',
            setSnackbar: 'snackbar/setSnackbar',
        }),

        copyAccessCode() {
            navigator.clipboard.writeText(this.university.access_code).then(() => {
                this.setSnackbar({message: 'Skopiowano kod: ' + this.university.access_code, color: 'success'});
            });
        },

        generateAccessCode() {
            this.generateNewAccessCode(this.university.id).then(() => {
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
