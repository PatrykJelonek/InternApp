<template>
    <v-container fluid>
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

export default {
    name: "Messages",
    components: {Chat, Chats},

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
            {text: 'Użytkownik', to: {name: 'user', params: {id: this.user.id}}},
            {text: 'Wiadomości', disabled: true}
        ]);
    }
}
</script>

<style scoped>

</style>
