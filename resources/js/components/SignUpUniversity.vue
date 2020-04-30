<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <h2>Dane uczelni</h2>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-autocomplete
                    v-model="university"
                    label="Uczelnia"
                    :outlined="outlinedCombobox"
                    :items="universities"
                    item-text="name"
                    item-value="id">

                </v-autocomplete>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapState} from "vuex";
    import store from "../store";

    export default {
        name: "SignUpUniversity",
        data() {
            return {
                university: '',
                outlinedCombobox: true,
                items: []
            }
        },
        methods: {
            //
        },
        computed: {
            ...mapState({
                universities: state => state.university.universities
            })
        },
        created: function () {
            store.dispatch('fetchUniversitiesFromApi');
        }
    }
</script>

<style scoped>

</style>
