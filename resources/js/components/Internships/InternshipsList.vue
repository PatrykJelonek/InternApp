<template>
    <v-card outlined>
        <v-data-table
            :headers="headers"
            :items="internships"
            :loading="isLoading"
            :items-per-page="10"
            @click:row="(item) => {this.$router.push({name: 'offer', params: {id: item.id}})}"
        >
            <template v-slot:item.action="{ item }">
                <v-btn small color="primary">Aplikuj</v-btn>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    export default {
        name: "InternshipsList",

        data() {
            return {
                isLoading: true,
                headers: [
                    {text: 'Nazwa', value: 'offer.name'},
                    {text: 'Firma', value: 'company.name'},
                    {text: 'Uczelnia', value: 'university.name'},
                    {text: 'Ilość miejsc', value: 'offer.places_number'},
                    {text: 'Akcje', value: 'action'},
                ],
            }
        },

        computed: {
            ...mapGetters({
                internships: 'internship/internships'
            })
        },

        methods: {
            ...mapActions({
                fetchInternships: 'internship/fetchInternships'
            })
        },

        created() {
            this.fetchInternships().then(() =>{
                this.isLoading = false;
            })
        }
    }
</script>

<style scoped>

</style>
