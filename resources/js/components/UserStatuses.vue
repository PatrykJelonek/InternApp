<template>

    <ul id="example-1">
        <li>Response Status: {{ resStatus }}</li>
        <li v-for="status in userStatuses" :key="status.id">
            <b>{{ status.name }}</b> - {{ status.description }} <button type="button" v-on:click="deleteItem(status.id)">Delete</button>
        </li>
    </ul>
</template>

<script>
    import { mapState, mapActions } from 'vuex';
    import store from '../store';

    export default {
        data: function () {
            return {
                resStatus: null,
                statuses: []
            }
        },
        computed: {
            ...mapState({
                userStatuses: state => state.userStatus.userStatuses
            }),

        },
        methods: {
            ...mapActions(["deleteUserStatus"]),
            deleteItem: function(statusId) {
                this.deleteUserStatus(statusId);
            }
        },
        created: function () {
            store.dispatch('fetchUserStatuses');
        }
    }
</script>

<style scoped>

</style>
