<template>
    <v-container fluid>
        <v-row v-if="!firstLoading">
            <v-col cols="12">
                <expand-card
                    title="Wiadomości"
                    description="abc"
                    :expand="false"
                >
                    <div class="my-5">
                        <v-row
                            no-gutters
                            class="cursor-pointer"
                            @click="loadMore"
                            v-if="chatMessages.next_page_url !== null"
                        >
                            <v-col
                                cols="12"
                                v-if="!newMessageLoading"
                                class="text-center text-caption text--secondary"
                            >
                                <v-icon small color="secondary">mdi-arrow-up</v-icon>
                                <p>Załaduj poprzednie wiadomości</p>
                            </v-col>
                            <v-col v-else class="text-center">
                                <v-progress-circular indeterminate color="primary"></v-progress-circular>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" class="pa-5s">
                                <v-virtual-scroll
                                    :items="messages"
                                    item-height="110"
                                    height="750"
                                    id="virtualScroll"
                                >
                                    <template v-slot:default="{index, item}">
                                        <chat-message
                                            :message="item.content"
                                            :user-first-name="item.user.first_name"
                                            :user-last-name="item.user.last_name"
                                            :user-id="item.user.id"
                                            :date="item.created_at"
                                            :next-date="index !== messages.length - 1 ? messages[index+1].created_at : item.created_at"
                                            :visible-central-date="index !== 0 && index !== messages.length - 1 ? isDateVisible(messages[index-1].created_at, item.created_at, messages[index+1].created_at) : (index!==messages.length - 1)"
                                            :self="item.user_id === user.id"
                                            :message-group-start="index !== 0 && index !== messages.length - 1 ? item.user.id !== messages[index-1].user.id : index === 0"
                                            :message-group="index !== 0 && index !== messages.length - 1 ? item.user.id === messages[index-1].user.id && item.user.id === messages[index+1].user.id : (index !== 0 || index !== messages.length - 1)"
                                            :message-group-end="index !== messages.length - 1 ? item.user.id !== messages[index+1].user.id : index === messages.length - 1"
                                        ></chat-message>
                                    </template>
                                </v-virtual-scroll>
                            </v-col>
                        </v-row>
                    </div>
                </expand-card>
            </v-col>
            <v-col cols="12" class="mt-5">
                <v-card color="card-background">
                    <v-form>
                        <v-row no-gutters>
                            <v-col cols="11">
                                <v-text-field
                                    v-model="message"
                                    solo
                                    background-color="card-background"
                                    flat
                                    hide-details
                                ></v-text-field>
                            </v-col>
                            <v-col cols="1" class="d-flex justify-center align-self-center">
                                <v-btn outlined color="primary" @click="submit">
                                    Wyślij
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card>
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
import PageLoader from "../_General/PageLoader";
import PageTitle from "../_Helpers/PageTitle";
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../_Helpers/ExpandCard";
import ChatMessage from "../Chat/ChatMessage";
import moment from "moment";

export default {
    name: "Chat",
    components: {ChatMessage, ExpandCard, PageTitle, PageLoader},

    data() {
        return {
            message: null,
            messages: null,
            firstLoading: false,
            newMessageLoading: false,
        }
    },

    computed: {
        ...mapGetters({
            chatMessages: 'chat/chatMessages',
            chatMessagesLoading: 'chat/chatMessagesLoading',
            user: 'auth/user',
        }),
    },

    methods: {
        ...mapActions({
            fetchChatMessages: 'chat/fetchChatMessages',
            sendMessage: 'chat/sendMessage',
            setBreadcrumbs: 'helpers/setBreadcrumbs',
        }),

        isDateVisible(previousDate, date, nextDate) {
            return moment(date).format('DD.MM.YYYY') !== moment(nextDate).format('DD.MM.YYYY') || moment(previousDate).format('DD.MM.YYYY') !== moment(date).format('DD.MM.YYYY');
        },

        async submit() {
            await this.sendMessage({
                uuid: this.$route.params.uuid,
                message: this.message
            }).then(() => {
                this.message = null;
                let virtualScroll = document.getElementById('virtualScroll');
                virtualScroll.scrollTop = virtualScroll.scrollHeight;
            }).catch((e) => {

            });
        },

        loadMore() {
            if (this.chatMessages.next_page_url !== null) {
                this.newMessageLoading = true;
                this.fetchChatMessages({
                    uuid: this.$route.params.uuid,
                    page: this.chatMessages.current_page + 1
                }).then(() => {
                    let responseMessages = [...this.chatMessages.data];
                    let virtualScroll = document.getElementById('virtualScroll');

                    this.messages.unshift(...responseMessages.reverse());
                    this.newMessageLoading = false;

                    virtualScroll.scrollTop = 0;
                }).catch((e) => {
                    this.newMessageLoading = false;
                });
            }
        },
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Użytkownik', to: {name: 'user', params: {id: this.user.id}}},
            {text: 'Wiadomości', disabled: true}
        ]);

        this.firstLoading = this.chatMessagesLoading;

        this.fetchChatMessages({uuid: this.$route.params.uuid}).then(() => {
            this.messages = [...this.chatMessages.data];
            this.firstLoading = this.chatMessagesLoading;
            this.messages.reverse();

            setTimeout(() => {
                let virtualScroll = document.getElementById('virtualScroll');
                virtualScroll.scrollTop = virtualScroll.scrollHeight;
            }, 100);
        }).catch((e) => {
            this.firstLoading = this.chatMessagesLoading;
        });

        Echo.channel(`chat.${this.$route.params.uuid}`).listen(`.messageSent`, (e) => {
            this.messages.push(e.data);
            let virtualScroll = document.getElementById('virtualScroll');
            virtualScroll.scrollTop = virtualScroll.scrollHeight;
        });
    },
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
