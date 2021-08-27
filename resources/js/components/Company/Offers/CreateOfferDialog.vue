<template>
    <v-dialog
        v-model="createOfferDialog"
        persistent
        max-width="1000px"
        :fullscreen="this.$vuetify.breakpoint.smAndDown"
    >
        <custom-card>
            <custom-card-title>
                <template v-slot:default>Dodaj ofertę</template>
                <template v-slot:subheader>Wypełnij poniższy formularz by dodać nową ofertę do serwisu.</template>
                <template v-slot:actions>
                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                small
                                icon
                                v-bind="attrs"
                                v-on="on"
                                @click="toggleCreateOfferDialog(false)">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </template>
                        <span>Zamknij</span>
                    </v-tooltip>
                </template>
            </custom-card-title>

            <v-row no-gutters>
                <v-col cols="12">
                    <create-offer-form></create-offer-form>
                </v-col>
            </v-row>
        </custom-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import CreateOfferForm from "./CreateOfferForm";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";
export default {
    name: "CreateOfferDialog",
    components: {CustomCardTitle, CustomCard, CreateOfferForm, ExpandCard},

    data() {
        return {
            show: true,
        }
    },

    computed: {
        ...mapGetters({
            createOfferDialog: 'helpers/createOfferDialog',
        }),
    },

    methods: {
        ...mapActions({
            toggleCreateOfferDialog: 'helpers/toggleCreateOfferDialog',
        }),
    },
}
</script>

<style scoped>

</style>
