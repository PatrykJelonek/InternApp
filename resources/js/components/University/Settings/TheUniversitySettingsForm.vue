<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Dane uczelni</template>
        </custom-card-title>
        <v-row no-gutters class="pa-5 mt-2">
            <v-col cols="12">
                <v-form>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Adres email"
                                :value="university.email"
                                outlined
                                hide-details
                                dense
                                :disabled="!hasUniversityRole(['deanery_worker','university_owner'])"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Strona internetowa"
                                :value="university.website"
                                outlined
                                hide-details
                                dense
                                :disabled="!hasUniversityRole(['deanery_worker','university_owner'])"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Numer telefonu"
                                :value="university.phone"
                                outlined
                                hide-details
                                dense
                                :disabled="!hasUniversityRole(['deanery_worker','university_owner'])"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" class="d-flex justify-end">
                            <v-btn
                                outlined
                                color="primary"
                                v-has-university-role="['deanery_worker','university_owner']"
                            >
                                Zapisz
                            </v-btn>
                        </v-col>
                    </v-row>
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
import {hasUniversityRole} from "../../../plugins/acl";

export default {
    name: "TheUniversitySettingsForm",
    components: {CustomCardTitle, CustomCard},
    data() {
        return {
            show: true,
            tabs: null,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
        }),
    },

    methods: {
        hasUniversityRole,

        ...mapActions({}),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        }
    },
}
</script>

<style scoped>

</style>
