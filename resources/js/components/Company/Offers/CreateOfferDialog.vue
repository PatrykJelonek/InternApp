<template>
    <v-dialog
        v-model="createOfferDialog"
        persistent
        max-width="800px"
        :fullscreen="this.$vuetify.breakpoint.smAndDown"
    >
        <expand-card
            title="Dodaj Ofertę"
            description="Wypełnij poniższy formularz by dodać nową ofertę do serwisu."
            :expand="false"
        >
            <template slot="buttons">
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
                    <span>Zamknij Okno</span>
                </v-tooltip>
            </template>
            <v-row class="pa-5">
                <v-col cols="12">
                    <create-offer-form></create-offer-form>
                </v-col>
            </v-row>
        </expand-card>
    </v-dialog>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";
import {mapActions, mapGetters} from "vuex";
import CreateOfferForm from "./CreateOfferForm";
export default {
    name: "CreateOfferDialog",
    components: {CreateOfferForm, ExpandCard},

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
    }
}
</script>

<style scoped>

</style>
