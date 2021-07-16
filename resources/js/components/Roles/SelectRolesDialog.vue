<template>
    <v-dialog
        v-model="dialogs['DIALOG_FIELD_SELECT_ROLES']"
        class="component-background"
        persistent
        max-width="600"
    >
        <custom-card :loading="rolesLoading">
            <custom-card-title>
                <template v-slot:default>Wybierz role</template>
                <template v-slot:actions>
                    <v-btn icon @click="toggleDialog({key: 'DIALOG_FIELD_SELECT_ROLES', val: false})">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </custom-card-title>
           <v-row no-gutters>
               <v-col cols="12" class="pa-5">
                   <v-select
                       v-model="selectedRoles"
                       :items="roles"
                       :loading="rolesLoading"
                       item-value="id"
                       item-text="display_name"
                       hide-details="auto"
                       label="Role"
                       multiple
                       chips
                       outlined
                       dense
                       class="component-background"
                       deletable-chips
                       small-chips
                   ></v-select>
               </v-col>
           </v-row>
            <custom-card-footer>
                <template v-slot:right>
                    <v-btn outlined color="primary" @click="submitFunction(selectedRoles)">
                        Zapisz
                    </v-btn>
                </template>
            </custom-card-footer>
        </custom-card>
    </v-dialog>
</template>

<script>
import CustomCard from "../_General/CustomCard";
import CustomCardTitle from "../_General/CustomCardTitle";
import CustomCardFooter from "../_General/CustomCardFooter";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "SelectRolesDialog",
    components: {CustomCardFooter, CustomCardTitle, CustomCard},
    props: ['groups', 'submitFunction', 'existentRolesId'],

    data() {
        return {
            selectedRoles: [],
        }
    },

    computed: {
        ...mapGetters({
            roles: 'role/roles',
            rolesLoading: 'role/rolesLoading',
            dialogs: 'helpers/dialogs',
        }),
    },

    methods: {
        ...mapActions({
            fetchRolesByGroups: 'role/fetchRolesByGroups',
            toggleDialog: 'helpers/toggleDialog'
        }),
    },

    created() {
        this.fetchRolesByGroups(this.groups).then((response) => {

        }).catch((e) => {

        });
    },

    watch: {
        existentRolesId(newVal, oldVal) {
            this.selectedRoles = newVal;
        }
    }
}
</script>

<style scoped>

</style>
