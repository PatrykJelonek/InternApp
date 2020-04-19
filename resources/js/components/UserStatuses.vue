<template>

    <ul id="example-1">
        <li>Response Status: {{ resStatus }}</li>
        <li v-for="status in statuses" :key="status.id">
            <b>{{ status.name }}</b> - {{ status.description }} <button type="button" v-on:click="deleteItem(status.id)">Delete</button>
        </li>
    </ul>
</template>

<script>
    export default {
        data: function () {
            return {
                resStatus: null,
                statuses: []
            }
        },
        methods: {
            read: async function() {
                await window.axios.get('/user_statuses', {validateStatus: (status) => {
                        this.resStatus = status;
                        return status < 400;
                    }})
                    .then(res => {
                        this.statuses = res.data;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            deleteItem: function(statusId) {
                window.axios({
                    method: 'delete',
                    headers: {'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content},
                    url: `/user_statuses/${statusId}`
                }).then(res => {
                    alert(res.data);
                })
            }
        },
        created: function () {
            this.read();
        }
    }
</script>

<style scoped>

</style>
