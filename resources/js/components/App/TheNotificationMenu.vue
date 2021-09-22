<template>
    <v-menu
        v-model="menu"
        :close-on-content-click="false"
        nudge-left="185px"
        nudge-bottom="35px"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                icon
                small
                v-on="on"
                v-bind="attrs"
                elevation="0"
                class="mx-5"
            >
                <v-badge
                    dot
                    color="primary"
                    :value="userUnreadNotifications.length > 0"
                >
                    <v-icon>mdi-bell-outline</v-icon>
                </v-badge>
            </v-btn>
        </template>

        <v-card width="400px" color="component-background" :loading="userUnreadNotificationsLoading">
            <template v-slot:progress>
                <v-progress-linear color="primary" indeterminate></v-progress-linear>
            </template>

            <v-list
                nav
                dense
                two-line
                class="pt-2"
                color="component-background"
                v-if="!userUnreadNotificationsLoading && userUnreadNotifications.length > 0"
            >
                <v-virtual-scroll
                    :items="userUnreadNotifications"
                    item-height="80px"
                    :height="userUnreadNotifications.length > 3 ? '300px' : userUnreadNotifications.length * 80 + 'px'"
                >
                    <template v-slot:default="{ item }">
                        <message-notification
                            :id="item.id"
                            :text="item.data.text"
                            :content="item.data.content"
                            :chat_uuid="item.data.chat_uuid"
                            :author="item.data.author"
                            v-if="item.type === MESSAGE_NOTIFICATION"
                        ></message-notification>
                        <questionnaire-answers-added-notification
                            :id="item.id"
                            :author="item.data.author"
                            :questionnaire-name="item.data.questionnaire_name"
                            v-if="item.type === QUESTIONNAIRE_ANSWERS_ADDED_NOTIFICATION"
                        ></questionnaire-answers-added-notification>
                    </template>
                </v-virtual-scroll>
            </v-list>
            <v-card-actions class="component-background d-flex justify-center">
                <span
                    class="text-caption text-center"
                    v-if="userUnreadNotifications.length > 0"
                >
                    <router-link :to="{name: 'notifications'}" class="white--text text-decoration-none more" exact>Pokaż wszystkie powiadomienia</router-link>
                </span>
                <span v-else class="text-subtitle-1 d-flex flex-column justify-center text--disabled">
                    <v-icon x-large class="mb-2 text--disabled">mdi-bell-cancel-outline</v-icon>
                    Brak nowych powiadomień!
                </span>
            </v-card-actions>
        </v-card>
    </v-menu>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import MessageNotification from "../Notifications/MessageNotification";
import QuestionnaireAnswersAddedNotification from "../Notifications/QuestionnaireAnswersAddedNotification";

export default {
    name: "TheNotificationMenu",
    components: {QuestionnaireAnswersAddedNotification, MessageNotification},
    data() {
        return {
            menu: false,
            MESSAGE_NOTIFICATION: 'App\\Notifications\\MessageSentNotification',
            QUESTIONNAIRE_ANSWERS_ADDED_NOTIFICATION: 'App\\Notifications\\QuestionnaireAnswersAddedNotification',
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            userUnreadNotifications: 'user/userUnreadNotifications',
            userUnreadNotificationsLoading: 'user/userUnreadNotificationsLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchUserUnreadNotifications: 'user/fetchUserUnreadNotifications',
            unshiftUserUnreadNotification: 'user/unshiftUserUnreadNotification',
            unshiftUserNotification: 'user/unshiftUserNotification',
        }),
    },

    created() {
        this.fetchUserUnreadNotifications().then(() => {

        }).catch((e) => {

        });

        Echo.private(`App.Models.User.${this.user.id}`)
            .notification((notification) => {
                this.unshiftUserUnreadNotification(notification);
                this.unshiftUserNotification(notification);
            });
    }
}
</script>

<style lang="scss" scoped>
.more {
    &:hover {
        color: #00C853 !important;
    }
}
</style>
