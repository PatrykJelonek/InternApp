<template>
    <custom-card :ripple="true">
        <v-row class="py-4 px-4 cursor-pointer" no-gutters
               @click="$router.push({name: 'offer', params: {slug: slug}})">
            <v-col cols="10">
                <v-row no-gutters>
                    <v-col cols="auto" class="mr-5 d-flex justify-center align-center">
                        <v-avatar rounded :color="logoUrl ? '' : 'primary'">
                            <v-img max-height="250px" :src="`/${logoUrl}`" v-if="logoUrl"></v-img>
                        </v-avatar>
                    </v-col>
                    <v-col cols="auto">
                        <v-row no-gutters>
                            <v-col cols="12" class="text-h6 d-flex align-center">
                                {{ name }}
                                <span class="text-caption text--secondary text-uppercase ml-3" v-if="interview">
                                    <v-tooltip right color="tooltip-background">
                                      <template v-slot:activator="{ on, attrs }">
                                          <v-icon small color="warning" v-bind="attrs" v-on="on" class="cursor-pointer">mdi-alert-outline</v-icon>
                                      </template>
                                      <span class="text-caption">Rozmowa kwalifikacyjna</span>
                                    </v-tooltip>
                                </span>
                            </v-col>
                        </v-row>
                        <v-row class="text-caption d-flex align-center align-content-center align-self-center"
                               no-gutters>
                            <v-col cols="auto">
                                {{ companyName }}
                            </v-col>
                            <v-col cols="auto" class="ml-3">
                                <v-icon small class="mr-2">mdi-map-marker</v-icon>
                                {{ address }}
                            </v-col>
                            <v-col cols="auto" class="ml-3">
                                <v-icon small class="mr-2">mdi-calendar-range</v-icon>
                                {{ dateRange }}
                            </v-col>
                            <v-col cols="auto" class="ml-3" v-if="category">
                                <v-icon small class="mr-2">mdi-tag</v-icon>
                                <v-chip small outlined label>
                                    {{ category }}
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-col>
            <v-col
                cols="2"
                class="d-flex align-center"
                v-if="canCreateAgreement || canApply"
            >
                <v-row no-gutters class="d-flex align-center justify-end">
                    <v-col cols="auto" class="d-flex justify-center align-center">
                        <menu-dots>
                            <template v-slot:items>
                                <v-list-item
                                    class="cursor-pointer"
                                    @click="openConfirmApplicationDialog(slug)"
                                    v-if="canApply">
                                    <v-list-item-title>Aplikuj</v-list-item-title>
                                </v-list-item>
                                <v-list-item class="cursor-pointer" v-if="canCreateAgreement">
                                    <v-list-item-title @click="openCreateAgreementDialog">
                                        Utwórz umowę
                                    </v-list-item-title>
                                </v-list-item>
                            </template>
                        </menu-dots>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import CustomCard from "../_General/CustomCard";
import MenuDots from "../_General/MenuDots";
import {mapActions} from "vuex";
import CustomConfirmDialog from "../_General/CustomConfirmDialog";

export default {
    name: "OffersListRow",
    components: {CustomConfirmDialog, MenuDots, CustomCard},
    props: [
        'name',
        'slug',
        'logoUrl',
        'interview',
        'companyName',
        'address',
        'dateRange',
        'category',
        'offer',
        'forStudent',
        'canApply',
        'canCreateAgreement',
    ],

    computed: {},

    methods: {
        ...mapActions({
            setDialogArgs: 'helpers/setDialogArgs',
            toggleDialog: 'helpers/toggleDialog',
            applyToInternship: 'agreement/applyToInternship',
            setSnackbar: 'snackbar/setSnackbar',
        }),

        openCreateAgreementDialog() {
            this.setDialogArgs({key: 'DIALOG_FIELD_CREATE_AGREEMENT_FROM_OFFER', val: this.offer});
            this.toggleDialog({key: 'DIALOG_FIELD_CREATE_AGREEMENT_FROM_OFFER', val: true});
        },

        openConfirmApplicationDialog(slug) {
            this.setDialogArgs({key: 'DIALOG_FIELD_CONFIRM_INTERNSHIP_APPLICATION', val: [slug]});
            this.toggleDialog({key: 'DIALOG_FIELD_CONFIRM_INTERNSHIP_APPLICATION', val: true});
        },
    }
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
