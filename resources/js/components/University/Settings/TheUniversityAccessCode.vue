<template>
    <v-card elevation="0" color="card-background">
        <template slot="progress">
            <v-progress-linear color="primary" indeterminate></v-progress-linear>
        </template>
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Kod dostępu
                    </v-list-item-title>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn-toggle borderless dense>
                        <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    small
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="show = !show">
                                    <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                                </v-btn>
                            </template>
                            <span>{{ show ? 'Zwiń' : 'Rozwiń' }}</span>
                        </v-tooltip>
                    </v-btn-toggle>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-expand-transition>
            <v-row v-show="show">
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
        </v-expand-transition>
    </v-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";

export default {
    name: "TheUniversityAccessCode",

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
