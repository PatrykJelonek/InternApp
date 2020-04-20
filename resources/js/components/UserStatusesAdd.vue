<template>
    <form @submit="onSumbit">
        <input v-model="status.name" type="text">
        <textarea v-model="status.description">

        </textarea>
        <button type="submit">Dodaj status</button>
    </form>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        data: () => {
            return {
                status: {
                    name: '',
                    description: '',
                }
            }
        },
        methods: {
            ...mapActions(["addUserStatus"]),
            onSumbit(e){
                this.addUserStatus({name: this.status.name, description: this.status.description});
                e.preventDefault();

                this.status = {};
            },
        }
    }
</script>

<style scoped>

</style>
