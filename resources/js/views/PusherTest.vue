<template>
    <div>
        <h2>Test</h2>
        <ul>
            <li v-for="message in messages">
                {{ message }}
            </li>
        </ul>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "PusherTest",

    data() {
        return {
            messages: [],
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
    },

    methods: {
        ...mapActions({
            setSnackbar: 'snackbar/setSnackbar'
        }),
    },

    created() {
        Echo.channel('channel').listen(`.messageSent`, (e) => {
            this.messages.push(e.message);
        });
    }
}
</script>

<style scoped>

</style>
