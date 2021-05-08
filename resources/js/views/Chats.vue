<template>
    <v-container>
        <v-row v-if="!userChatsLoading">
            <v-col cols="12">
                <page-title>Konwersacje</page-title>
            </v-col>
            <v-col cols="12">
                <expand-card
                    title="Twoje konwersacje"
                    description="Lista twoich konwersacji z innymi użytkownikami serwisu."
                >
                    <v-row class="pa-5">
                        <v-col
                            cols="12"
                            class="pa-2"
                            v-for="chat in userChats"
                            :key="chat.uuid"
                        >
                            <v-card
                                color="grey lighten-4"
                                elevation="0"
                                class="cursor-pointer"
                                @click="$router.push({name: 'chat', params: {uuid: chat.uuid}})"
                            >
                                <v-card-title>
                                    <template
                                        v-for="(chatUser, index) in chat.users"
                                    >
                                        <template v-if="chatUser.id !== user.id">
                                            {{ chatUser.first_name + ' ' + chatUser.last_name }}
                                            <span v-if="chat.users.length - 1 !== index">,&nbsp;</span>
                                        </template>
                                    </template>
                                </v-card-title>
                            </v-card>
                        </v-col>
                    </v-row>
                </expand-card>
            </v-col>
        </v-row>
        <v-row v-else class="text-center">
            <v-col cols="12">
                <page-loader></page-loader>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageLoader from "../components/_General/PageLoader";
import PageTitle from "../components/_Helpers/PageTitle";
import ExpandCard from "../components/_Helpers/ExpandCard";

export default {
    name: "Chats",
    components: {ExpandCard, PageTitle, PageLoader},

    computed: {
        ...mapGetters({
            userChats: 'chat/userChats',
            userChatsLoading: 'chat/userChatsLoading',
            user: 'auth/user'
        }),
    },

    methods: {
        ...mapActions({
            fetchUserChats: 'chat/fetchUserChats',
        }),
    },

    created() {
        this.fetchUserChats().then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
