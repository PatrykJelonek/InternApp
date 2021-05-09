<template>
    <v-container>
        <v-row v-if="!firstLoading">
            <v-col cols="12">
                <page-title>Konwersacja</page-title>
            </v-col>
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
                                <template v-for="(message, index) in messages">
                                    <chat-message
                                        :message="message.content"
                                        :user-first-name="message.user.first_name"
                                        :user-last-name="message.user.last_name"
                                        :user-id="message.user.id"
                                        :date="message.created_at"
                                        :next-date="index !== messages.length - 1 ? messages[index+1].created_at : message.created_at"
                                        :visible-central-date="index !== 0 && index !== messages.length - 1 ? isDateVisible(messages[index-1].created_at, message.created_at, messages[index+1].created_at) : (index!==messages.length - 1)"
                                        :self="message.user_id === user.id"
                                        :message-group-start="index !== 0 && index !== messages.length - 1 ? message.user.id !== messages[index-1].user.id : index === 0"
                                        :message-group="index !== 0 && index !== messages.length - 1 ? message.user.id === messages[index-1].user.id && message.user.id === messages[index+1].user.id : (index !== 0 || index !== messages.length - 1)"
                                        :message-group-end="index !== messages.length - 1 ? message.user.id !== messages[index+1].user.id : index === messages.length - 1"
                                    ></chat-message>
                                </template>
                            </v-col>
                        </v-row>
                    </div>
                </expand-card>
            </v-col>
            <v-col cols="12" class="mt-5">
                <v-card>
                    <v-form>
                        <v-row no-gutters>
                            <v-col cols="11">
                                <v-text-field
                                    v-model="message"
                                    outlined
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
import PageLoader from "../components/_General/PageLoader";
import PageTitle from "../components/_Helpers/PageTitle";
import {mapActions, mapGetters} from "vuex";
import ExpandCard from "../components/_Helpers/ExpandCard";
import ChatMessage from "../components/Chat/ChatMessage";
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
            user: 'auth/user'
        }),
    },

    methods: {
        ...mapActions({
            fetchChatMessages: 'chat/fetchChatMessages',
            sendMessage: 'chat/sendMessage',
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
                    this.messages.unshift(...responseMessages.reverse());
                    this.newMessageLoading = false;
                }).catch((e) => {
                    this.newMessageLoading = false;
                });
            }
        },
    },

    created() {
        this.firstLoading = this.chatMessagesLoading;

        this.fetchChatMessages({uuid: this.$route.params.uuid}).then(() => {
            this.messages = [...this.chatMessages.data];
            this.firstLoading = this.chatMessagesLoading;
            this.messages.reverse();
        }).catch((e) => {
            this.firstLoading = this.chatMessagesLoading;
        });

        Echo.channel(`chat.${this.$route.params.uuid}`).listen(`.messageSent`, (e) => {
            this.messages.push(e.data);
        });
    }
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
