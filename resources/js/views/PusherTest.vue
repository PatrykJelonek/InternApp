<template>
    <ul>
        <li v-for="message in messages">
            {{ message }}
        </li>
    </ul>
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
        console.log('asd');
        Echo.channel('channel').listen('.task.created', (e) => {
            this.tasks.push(task.body)
        });
    }
}
</script>

<style scoped>

</style>
