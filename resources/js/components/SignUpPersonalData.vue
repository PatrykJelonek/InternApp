<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <h2>Dane personalne</h2>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-text-field
                    v-model="firstName"
                    label="Imię"
                    type="text"
                    prepend-inner-icon="mdi-badge-account-horizontal-outline"
                    required
                    :outlined="outlinedInput"
                    :dense="denseInput"
                    hide-details="auto"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-text-field
                    v-model="lastName"
                    label="Nazwisko"
                    type="text"
                    prepend-inner-icon="mdi-badge-account-horizontal"
                    required
                    :outlined="outlinedInput"
                    :dense="denseInput"
                    hide-details="auto"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-text-field
                    v-model="phone"
                    label="Numer telefonu"
                    type="phone"
                    prepend-inner-icon="mdi-phone"
                    required
                    :outlined="outlinedInput"
                    :dense="denseInput"
                    hide-details="auto"
                ></v-text-field>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "SignUpPersonalData",
        data() {
            return {
                firstName: '',
                lastName: '',
                phone: '',

                outlinedInput: true,
                denseInput: false,
            }
        }
    }
</script>

<style scoped>

</style>
