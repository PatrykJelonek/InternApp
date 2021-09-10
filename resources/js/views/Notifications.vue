<template>
    <v-container fluid class="pa-0">
        <page-title>
            <template v-slot:default>Powiadomienia</template>
            <template v-slot:subheader>Lista powiadomień użytkownika {{ user.full_name }}</template>
            <template v-slot:actions>
                <v-btn-toggle></v-btn-toggle>
            </template>
        </page-title>

        <v-card rounded :loading="userNotificationsLoading" color="component-background" elevation="0">
            <template v-slot:progress>
                <v-progress-linear color="primary" indeterminate></v-progress-linear>
            </template>

            <v-card-title class="d-flex justify-end px-5 py-2">
                <v-card-actions class="d-flex justify-end pa-2">
                    <v-btn-toggle dense background-color="transparent" active-class="primary--text" mandatory>
                        <v-btn small class="text--disabled" :value="true" outlined>Wszystkie</v-btn>
                    </v-btn-toggle>
                </v-card-actions>
            </v-card-title>

            <v-divider></v-divider>

            <v-list
                nav
                dense
                two-line
                color="component-background"
                class="px-3 py-2"
                v-if="!userNotificationsLoading && userNotifications.length > 0"
            >
                <v-virtual-scroll
                    :items="userNotifications"
                    item-height="80"
                    :height="userNotifications.length > 10 ? '800px' : userNotifications.length * 80 + 'px'"
                    @scroll.native="scrolling"
                >
                    <template v-slot:default="{ item }">
                        <v-list-item link dense>
                            <v-list-item-icon>
                                <v-icon
                                    small
                                    :color="item.read_at ? '' : 'primary'"
                                >{{ item.read_at ? 'mdi-bell-outline' : 'mdi-bell-ring' }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>{{ item.data.text }}</v-list-item-title>
                                <v-list-item-subtitle>{{ item.data.content }}</v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action>
                                <v-list-item-action-text>{{ moment(item.created_at).fromNow() }}</v-list-item-action-text>
                            </v-list-item-action>
                        </v-list-item>
                    </template>
                </v-virtual-scroll>
            </v-list>

            <v-card-actions class="d-flex justify-center" style="height: 65px">
                <v-fade-transition>
                    <div class="d-flex justify-center flex-column" v-if="userNotifications.length > 10 && isVisible">
                        <span class="text--disabled text-caption">Scroll'uj po więcej!</span>
                        <v-icon class="text--disabled" small>mdi-chevron-down</v-icon>
                    </div>
                    <div v-else class="d-flex justify-center flex-column">
                        <v-icon class="orange--text text--accent-3" small>mdi-fire</v-icon>
                        <span class="text-caption text--disabled">To wszystko!</span>
                    </div>
                </v-fade-transition>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
import {debounce} from 'lodash';
import {mapActions, mapGetters} from "vuex";
import MessageNotification from "../components/Notifications/MessageNotification";
import PageTitle from "../components/_Helpers/PageTitle";

export default {
    name: "Notifications",
    components: {PageTitle, MessageNotification},

    data() {
        return {
            isVisible: true,
            visible: this.ALL,
            ALL: 'all',
            READ: 'read',
            UNREAD: 'unread',
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            userNotifications: 'user/userNotifications',
            userNotificationsLoading: 'user/userNotificationsLoading'
        }),
    },

    methods: {
        ...mapActions({
            setBreadcrumbs: 'helpers/setBreadcrumbs',
            fetchUserNotifications: 'user/fetchUserNotifications',
        }),

        scrolling (event) {
            const element = event.currentTarget || event.target;
            this.isVisible = !(element && element.scrollHeight - element.scrollTop === element.clientHeight);
        },
    },

    created() {
        this.setBreadcrumbs([
            {text: 'Panel', to: {name: 'panel'}, exact: true},
            {text: 'Konto', to: {name: 'user', params: {id: this.user.id}}, exact: true},
            {text: 'Powiadomienia', to: {name: 'notifications'}}
        ]);

        this.fetchUserNotifications().then(() => {

        }).catch(() => {

        });

        this.scrolling = debounce(this.scrolling, 200)
    }
}
</script>

<style scoped>

</style>
