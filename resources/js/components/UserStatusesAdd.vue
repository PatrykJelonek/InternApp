<template>
    <form @submit="onSumbit">
        <input v-model="name" type="text">
        <textarea v-model="description">

        </textarea>
        <button type="submit">Dodaj status</button>
    </form>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        data: () => {
            return {
                name: '',
                description: ''
            }
        },
        methods: {
            ...mapActions(["addUserStatus"]),
            onSumbit(e){
              e.preventDefault();
              this.addUserStatus({name: this.name, description: this.description});
            },
        }
    }
</script>

<style scoped>

</style>
