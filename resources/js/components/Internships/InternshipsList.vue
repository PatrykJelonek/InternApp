<template>
    <v-card outlined>
        <v-data-table
            :headers="headers"
            :items="internships"
            :loading="isLoading"
            :items-per-page="10"
        >
            <template v-slot:item.action="{ item }" v-if="this.haveRole(['student'])">
                <v-btn small color="primary" v-if="item.offer.places_number > 0" @click="clickToApply(item)">Aplikuj</v-btn>
                <v-btn small color="primary" disabled v-else>Aplikuj</v-btn>
            </template>
        </v-data-table>

        <v-snackbar
            v-model="snackbar"
            :color="snackbarColor"
            right
            bottom
            :timeout="6000"
        >
            {{ snackbarText }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    dark
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                >
                    Zamknij
                </v-btn>
            </template>
        </v-snackbar>
    </v-card>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    export default {
        name: "InternshipsList",

        data() {
            return {
                snackbarText: '',
                snackbarColor: '',
                snackbar: false,
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
                internships: 'internship/internships',
                roles: 'auth/roles',
            })
        },

        methods: {
            ...mapActions({
                fetchInternships: 'internship/fetchInternships',
                apply: 'internship/apply'
            }),

            async clickToApply(item) {
                await this.apply(item).then(() => {
                    this.snackbarText = 'Aplikowałeś na tą praktykę!';
                    this.snackbarColor = 'success';
                    this.snackbar = true;
                    item.offer.places_number--;
                }).catch((e) => {
                    this.snackbarText = 'Przepraszamy, coś poszło nie tak!';
                    this.snackbarColor = 'error';
                    this.snackbar = true;
                })
            },

            haveRole: function (rolesToCheck) {
                let haveRole = false;
                this.roles.forEach((role) => {
                    rolesToCheck.forEach((roleToCheck) => {
                        if(roleToCheck === role)
                            haveRole = true;
                    });
                });

                return haveRole;
            }
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
