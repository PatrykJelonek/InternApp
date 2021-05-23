<template>
    <v-list-item link >
        <v-list-item-content>
            <v-list-item-title>{{ text }}</v-list-item-title>
            <v-list-item-subtitle>{{ content }}</v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-icon @click="markAsRead">
            <v-icon small>mdi-close</v-icon>
        </v-list-item-icon>
    </v-list-item>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "MessageNotification",
    props: ['text', 'content', 'id'],

    methods: {
        ...mapActions({
            markNotificationAsRead: 'user/markNotificationAsRead',
            setSnackbar: 'snackbar/setSnackbar'
        }),

        async markAsRead() {
            console.log(this.id);
           await this.markNotificationAsRead(this.id).then(() => {
                this.$store.commit('user/MARK_AS_READ', this.id);
            }).catch((e) => {
                this.setSnackbar({message: 'Coś poszło nie tak!', color: 'error'});
           });
        }
    }
}
</script>

<style scoped>

</style>
