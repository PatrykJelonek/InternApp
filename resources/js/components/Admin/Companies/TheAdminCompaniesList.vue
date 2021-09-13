<template>
    <v-row>
        <v-col cols="12">
            <v-data-table>

            </v-data-table>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "TheAdminCompaniesList",

    data() {
        return {
            headers: [
                {text: 'Nazwa', value: 'name'},
                {text: 'Typ', value: 'type.name'},
                {text: 'Adres', value: 'full_address'},
                {text: 'Email', value: 'email'},
                {text: 'Akcje', value: 'actions'},
            ],
        }
    },

}
</script>

<style scoped>

</style>
