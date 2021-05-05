<template>
    <div>
        <v-row v-if="!messagesLoading">
            <v-col cols="12">
                <v-card
                    v-for="message in messages"
                    :key="message.id"
                >
                    <v-card-text>{{ message.content }}</v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-row v-else class="text-center">
            <v-col cols="12">
                <page-loader></page-loader>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageLoader from "../_General/PageLoader";

export default {
    name: "MessagesList",
    components: {PageLoader},

    data() {
        return {
            messageGroups: [],
        }
    },

    computed: {
        ...mapGetters({
            messages: 'user/userMessages',
            messagesLoading: 'user/userMessagesLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchUserMessages: 'user/fetchUserMessages',
        }),
    },

    created() {
        this.fetchUserMessages().then(() => {

        }).catch((e) => {

        });
    }
}
</script>

<style scoped>

</style>
