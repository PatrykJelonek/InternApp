<template>
    <ul id="example-1">
        <li v-for="status in statuses" :key="status.id">
            <b>{{ status.name }}</b> - {{ status.description }}
        </li>
    </ul>
</template>

<script>
    export default {
        data: function () {
            return {
                statuses: null,
            }
        },
        methods: {
            read: function() {
                window.axios.get('/user_statuses').then(res => {
                    this.statuses = res.data;
                });
            },
        },
        created: function () {
            this.read();
        }
    }
</script>

<style scoped>

</style>
