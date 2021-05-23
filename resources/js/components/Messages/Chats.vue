<template>
    <v-container fluid>
        <v-row v-if="!userChatsLoading" no-gutters>
            <v-col cols="12">
                <custom-card :fill-height="true">
                    <v-card-title>
                        <span class="text-h6 font-weight-medium">Konwersacje</span>
                    </v-card-title>

                    <v-divider></v-divider>

                    <v-list nav color="component-background">
                        <v-list-item
                            link
                            v-for="chat in userChats"
                            :key="chat.uuid" :to="{name: 'chat', params: {uuid: chat.uuid}}"
                            active-class="primary--text"
                        >
                            <v-list-item-avatar class="text-caption">
                                <v-avatar color="component-background" v-if="chat.users.length > 2">
                                    {{ chat.users.length - 1 + '+' }}
                                </v-avatar>
                                <v-avatar color="component-background" v-else>
                                    {{ chat.users[0].id !== user.id ? chat.users[0].first_name[0] + ' ' + chat.users[0].last_name[0] : chat.users[1].first_name[0] + ' ' + chat.users[1].last_name[0] }}
                                </v-avatar>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>
                                    <template v-for="(chatUser, index) in chat.users">
                                        <template v-if="chatUser.id !== user.id">
                                            {{ chatUser.first_name + ' ' + chatUser.last_name }}
                                            <span v-if="chat.users.length - 1 !== index">,&nbsp;</span>
                                        </template>
                                    </template>
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </custom-card>
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
import PageLoader from "../_General/PageLoader";
import PageTitle from "../_Helpers/PageTitle";
import ExpandCard from "../_Helpers/ExpandCard";
import CustomCard from "../_General/CustomCard";

export default {
    name: "Chats",
    components: {CustomCard, ExpandCard, PageTitle, PageLoader},

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
    },
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
