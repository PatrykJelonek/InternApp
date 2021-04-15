<template>
    <div>
        <v-row>
            <v-col cols="12">
                <student-offers-list></student-offers-list>
            </v-col>
        </v-row>
        <v-row class="mt-5">
            <v-col cols="12" class="text-center">
                Masz własną ofertę?
            </v-col>
            <v-col cols="12" class="text-center">
                <v-btn
                    outlined
                    color="primary"
                    @click.stop="toggleDialog"
                >
                    Zgłoś własne miejsce praktyk
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <create-internship-dialog></create-internship-dialog>
        </v-row>
    </div>
</template>

<script>
import StudentOffersList from "./StudentOffersList";
import {mapActions} from "vuex";
import CreateInternshipDialog from "./CreateInternshipDialog";

export default {
    name: "TheStudentOffers",
    components: {CreateInternshipDialog, StudentOffersList},

    methods: {
        ...mapActions({
            toggleDialog: 'helpers/toggleCreateInternshipDialog',
        }),
    }
}
</script>

<style scoped>

</style>
