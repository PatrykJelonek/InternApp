<template>
    <v-container>
        <v-row v-if="!chatMessagesLoading">
            <v-col cols="12">
                <page-title>Konwersacja</page-title>
            </v-col>
            <v-col cols="12">
                <expand-card
                    title="Wiadomości"
                    description="abc"
                    :expand="false"
                >

                    <div class="pa-5">
                        <template
                            v-for="(message, index) in messages"
                        >
                            <chat-message
                                :message="message.content"
                                :user-first-name="message.user.first_name"
                                :user-last-name="message.user.last_name"
                                :user-id="message.user.id"
                                :date="message.created_at"
                                :next-date="index !== messages.length - 1 ? messages[index+1].created_at : message.created_at"
                                :self="message.user_id === user.id"
                                :message-group-start="index !== 0 && index !== messages.length - 1 ? message.user.id !== messages[index-1].user.id && message.user.id === messages[index+1].user.id : index === 0 || index === messages.length - 1"
                                :message-group="index !== 0 && index !== messages.length - 1 ? message.user.id === messages[index-1].user.id && message.user.id === messages[index+1].user.id : (index !== 0 || index !== messages.length - 1)"
                                :message-group-end="index !== messages.length - 1 ? message.user.id !== messages[index+1].user.id : index === messages.length - 1"
                            ></chat-message>
                        </template>
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

export default {
    name: "Chat",
    components: {ChatMessage, ExpandCard, PageTitle, PageLoader},

    data() {
        return {
            message: null,
            messages: null,
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

        async submit() {
            await this.sendMessage({
                uuid: this.$route.params.uuid,
                message: this.message
            }).then(() => {
                this.message = null;
            }).catch((e) => {
                console.log(e.response)
            });
        }
    },

    created() {
        this.fetchChatMessages(this.$route.params.uuid).then(() => {
            this.messages = this.chatMessages;
        }).catch((e) => {

        });

        Echo.channel(`chat.${this.$route.params.uuid}`).listen(`.messageSent`, (e) => {
            console.log(e);
            this.messages.push(e.data);
        });
    }
}
</script>

<style scoped>

</style>
