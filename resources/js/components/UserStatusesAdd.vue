<template>
    <form>
        <input v-model="name" type="text">
        <textarea v-model="description">

        </textarea>
        <button type='button' v-on:click="send">Dodaj status</button>
    </form>
</template>

<script>
    export default {
        data: () => {
            return {
                name: '',
                description: ''
            }
        },
        methods: {
            send: async function() {
                await window.axios({
                    method: 'post',
                    url: 'user_statuses',
                    headers: {'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content},
                    data: {
                        name: this.name,
                        description: this.description
                    }
                }).then(res => {
                    alert(res.data);
                })
                .catch(err => {
                    console.log(err);
                });
            }
        }
    }
</script>

<style scoped>

</style>
