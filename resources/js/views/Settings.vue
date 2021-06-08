<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="4" lg="2">
                <custom-card>
                    <v-card-header title="Awatar"></v-card-header>
                    <change-user-avatar-form></change-user-avatar-form>
                </custom-card>
            </v-col>
            <v-col cols="12" md="8" lg="6" xl="4">
                <custom-card>
                    <v-card-header title="Konto"></v-card-header>
                    <change-user-personal-data-form></change-user-personal-data-form>
                </custom-card>
            </v-col>
            <v-col cols="12" md="12" lg="4" xl="3">
                <custom-card>
                    <v-card-header title="Hasło"></v-card-header>
                    <change-user-password-form></change-user-password-form>
                </custom-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CustomCard from "../components/_General/CustomCard";
import PageTitle from "../components/_Helpers/PageTitle";
import VCardHeader from "../components/_Helpers/VCardHeader";
import ChangeUserPersonalDataForm from "../components/Account/Settings/ChangeUserPersonalDataForm";
import ChangeUserPasswordForm from "../components/Account/Settings/ChangeUserPasswordForm";
import ChangeUserAvatarForm from "../components/Account/Settings/ChangeUserAvatarForm";

export default {
    name: "Settings",
    components: {
        ChangeUserAvatarForm,
        ChangeUserPasswordForm, ChangeUserPersonalDataForm, VCardHeader, PageTitle, CustomCard},

    data() {
        return {}
    },

    computed: {
        ...mapGetters({
            user: 'auth/user'
        })
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Konto', to: {name: 'user', params: {id: this.user.id}}},
            {text: 'Ustawienia', disabled: true}
        ]);


    }
}
</script>

<style scoped>

</style>
