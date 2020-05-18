<template>
    <v-form>
        <v-row>
            <v-col>
                <v-text-field
                    label="Nazwa uczelni"
                    v-model="university.name"
                    outlined
                    dense
                    hide-details="auto"
                    placeholder="Politechnika Warszawska"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-select
                    label="Typ uczelni"
                    v-model="university.universityTypeId"
                    :items="universityTypes"
                    item-text="name"
                    item-value="id"
                    outlined
                    dense
                    hide-details
                    class="text-capitalize"
                    no-data-text="Brak typów uczelni!"
                    placeholder="Techniczna"
                ></v-select>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="5">
                <v-text-field
                    label="Ulica"
                    v-model="university.street"
                    outlined
                    dense
                    hide-details="auto"
                    placeholder="Wojska Polskiego"
                ></v-text-field>
            </v-col>
            <v-col cols="3">
                <v-text-field
                    label="Numer budynku"
                    v-model="university.streetNumber"
                    outlined
                    dense
                    hide-details="auto"
                    placeholder="12a/3"
                ></v-text-field>
            </v-col>
            <v-col cols="4">
                <v-autocomplete
                    label="Miasto"
                    v-model="university.cityId"
                    :items="cities"
                    item-text="name"
                    item-value="id"
                    outlined
                    dense
                    hide-details
                    placeholder="Warszawa"
                ></v-autocomplete>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-text-field
                    label="Email kontakowy"
                    v-model="university.email"
                    outlined
                    dense
                    hide-details="auto"
                    placeholder="email@example.com"
                ></v-text-field>
            </v-col>
            <v-col>
                <v-text-field
                    label="Numer kontaktowy"
                    v-model="university.phone"
                    outlined
                    dense
                    hide-details="auto"
                    placeholder="123-456-789"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-text-field
                    label="Strona internetowa"
                    v-model="university.website"
                    outlined
                    dense
                    hide-details="auto"
                    placeholder="www.pw.edu.pl"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col class="d-flex justify-end">
                <v-btn color="blue accent-4" dark large @click="submit">Dodaj uczelnie</v-btn>
            </v-col>
        </v-row>
    </v-form>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "UniversityCreateForm",

        data() {
            return {
                university: {
                    name: null,
                    universityTypeId: null,
                    cityId: null,
                    street: null,
                    streetNumber: null,
                    email: null,
                    phone: null,
                    website: null,
                }
            }
        },

        computed: {
            ...mapGetters({
                universityTypes: 'university/universityTypes',
                cities: 'city/cities'
            }),
        },

        methods: {
            ...mapActions({
                fetchUniversityTypes: 'university/fetchUniversityTypes',
                fetchCities: 'city/fetchCities',
                createUniversity: 'university/createUniversity'
            }),

            async submit(e) {
                await this.createUniversity(this.university).then(() => {
                    this.$router.go('/universities');
                }).catch((e) => {
                    console.log(e.response.data);
                });
            }
        },

        created() {
            this.fetchUniversityTypes();
            this.fetchCities();
        },
    }
</script>

<style scoped>

</style>
