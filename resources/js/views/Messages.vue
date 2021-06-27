<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Wiadomości</template>
            <template v-slot:subheader>Lista wiadomości użytkownika {{ user.full_name }}</template>
            <template v-slot:actions>
                <v-btn-toggle></v-btn-toggle>
            </template>
        </page-title>

        <v-row>
            <v-col cols="12" lg="4">
                <chats></chats>
            </v-col>
            <v-col cols="12" lg="8">
                <router-view :key="$route.params.uuid"></router-view>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Chats from "../components/Messages/Chats";
import Chat from "../components/Messages/Chat";
import PageTitle from "../components/_Helpers/PageTitle";

export default {
    name: "Messages",
    components: {PageTitle, Chat, Chats},

    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
        }),
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Konto', to: {name: 'user', params: {id: this.user.id}}},
            {text: 'Wiadomości', disabled: true}
        ]);
    }
}
</script>

<style scoped>

</style>
